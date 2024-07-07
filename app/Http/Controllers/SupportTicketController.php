<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\SoftDeletes;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;

use Carbon\Carbon;

use App\Models\SiteSettings;
use App\Models\SupportTicket;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\SupportTicketsExport;

class SupportTicketController extends VoyagerBaseController
{
    public function insert(Request $request)
    {
        //Limitation of request amount (one request per 3 minutes)
        if (null !== Session::get('lastRequestTime')) {
            $currentFullTime = date('d-m-Y h:i:s');
            $to_time = strtotime(Session::get('lastRequestTime'));
            $from_time = strtotime($currentFullTime);
            $diffirenceBetweenTime = round(abs($to_time - $from_time) / 60, 2);
            if ($diffirenceBetweenTime < 0) {
                return redirect('Index?error=' . __('Подождите 3 минуты, перед подачей следующей заявки'));
            }
        }

        //Data validation
        $request->validate(
            [
                'fullName' => 'required',
                'testType' => 'required',
                'course' => 'required',
                'department' => 'required',
                'subject' => 'required',
                'email' => ['required', 'email'],
                'phoneNumber' => 'required',
                'reason' => 'required',
                'confirmationImage.*' => 'max:12000',
                'confirmationImage' => 'max:5',
            ]
        );

        $fullName = $request->input('fullName');
        $testType = $request->input('testType');
        $course = $request->input('course');
        $department = $request->input('department');
        $subject = $request->input('subject');
        $email = $request->input('email');
        $phoneNumber = $request->input('phoneNumber');
        $extraTextInfo = $request->input('extraTextInfo');
        $reason = $request->input('reason');

        if ($request->hasFile('confirmationImage')) {
            //Add this to file path, to save images like "June2024" 
            $currentDate = Carbon::now();
            $monthAndYear = $currentDate->format('FY');

            //File paths json array
            $filePaths = [];

            foreach ($request->file('confirmationImage') as $image) {

                $filePath = Storage::put("public/supporttickets/$monthAndYear", $image);

                $savedFileName = basename($filePath);

                $filePaths[] = "supporttickets\\$monthAndYear\\$savedFileName";
                $jsonFilePaths = json_encode($filePaths);
            }
        }

        $data = array(
            'fullName' => $fullName,
            'testType' => $testType,
            'course' => $course,
            'department' => $department,
            'subject' => $subject,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'extraTextInfo' => $extraTextInfo,
            'reason' => $reason,
            'confirmationImages' => $jsonFilePaths,
            'created_at' => now(),
        );
        SupportTicket::insert($data);

        $supportTicketID = DB::getPdo()->lastInsertId();

        Session::put('lastRequestTime', date('d-m-Y h:i:s'));

        //Set cookies for later checking support ticket status
        Cookie::queue(Cookie::forever('email', $email));
        Cookie::queue(Cookie::forever('supportTicketID', $supportTicketID));

        return redirect('Index?message=' . __('Вы успешно подали заявку, ваш номер заявки: ')  . $supportTicketID . __('. Сохраните этот номер!'));
    }

    public function sendNew()
    {
        $canSendSupportTickets = SiteSettings::canSendRequests();
        if (!$canSendSupportTickets) {
            return redirect('/Index?error=Сейчас нельзя подавать новые заявки');
        }

        return view('SupportTicketNew');
    }

    public function chooseByStatus(Request $request, $status)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = 'supporttickets';

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchNames = $dataType->browseRows->mapWithKeys(function ($row) {
                return [$row['field'] => $row->getTranslatedAttribute('display_name')];
            });
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            $query = $model::select($dataType->name . '.*');

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query->{$dataType->scope}();
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';

                $searchField = $dataType->name . '.' . $search->key;
                if ($row = $this->findSearchableRelationshipRow($dataType->rows->where('type', 'relationship'), $search->key)) {
                    $query->whereIn(
                        $searchField,
                        $row->details->model::where($row->details->label, $search_filter, $search_value)->pluck('id')->toArray()
                    );
                } else {
                    if ($dataType->browseRows->pluck('field')->contains($search->key)) {
                        $query->where($searchField, $search_filter, $search_value);
                    }
                }
            }

            $row = $dataType->rows->where('field', $orderBy)->firstWhere('type', 'relationship');
            if ($orderBy && (in_array($orderBy, $dataType->fields()) || !empty($row))) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                if (!empty($row)) {
                    $query->select([
                        $dataType->name . '.*',
                        'joined.' . $row->details->label . ' as ' . $orderBy,
                    ])->leftJoin(
                        $row->details->table . ' as joined',
                        $dataType->name . '.' . $row->details->column,
                        'joined.' . $row->details->key
                    );
                }

                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            };
            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        if ($status != 'all') {
            //Choose only needed tickets
            switch ($status) {
                case 'underReview':
                    $translatedStatus = 'На рассмотрении';
                    break;
                case 'approved':
                    $translatedStatus = 'Одобрена';
                    break;
                case 'rejected':
                    $translatedStatus = 'Отклонена';
                    break;
                default:
                    $translatedStatus = 'На рассмотрении';
                    break;
            }
            $dataTypeContent = $dataTypeContent->where('supportTicketStatus', $translatedStatus);
        }


        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        // Define list of columns that can be sorted server side
        $sortableColumns = $this->getSortableColumns($dataType->browseRows);

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortableColumns',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showCheckboxColumn'
        ));
    }

    public function approveSupportTicket($support_ticket_id)
    {
        SupportTicket::where('id', $support_ticket_id)->update(['supportTicketStatus' => 'Одобрена']);

        return back();
    }

    public function rejectSupportTicket($support_ticket_id)
    {
        SupportTicket::where('id', $support_ticket_id)->update(['supportTicketStatus' => 'Отклонена']);

        return back();
    }

    public function supportTicketStatusCookie()
    {
        $email = Cookie::get('email');
        $supportTicketID = Cookie::get('supportTicketID');

        $supportTicket = SupportTicket::where('email', $email)
            ->where('id', $supportTicketID);

        //If cookies not set or ticket doesn't exists, then redirect to manual input
        if (
            $email == null
            || $supportTicketID == null
            || !($supportTicket->exists())
        ) {
            return view('SupportTicketStatus');
        }

        return $this->supportTicketStatusCheck($email, $supportTicketID);
    }

    public function supportTicketStatus(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
                'supportTicketID' => 'required',
            ]
        );

        $email = $request->input('email');
        $supportTicketID = $request->input('supportTicketID');

        return $this->supportTicketStatusCheck($email, $supportTicketID);
    }

    private function supportTicketStatusCheck($email, $supportTicketID)
    {
        $supportTicket = SupportTicket::where('email', $email)
            ->where('id', $supportTicketID);

        if ($supportTicket->exists()) {
            $supportTicketStatus = $supportTicket->first()->supportTicketStatus;
        } else {
            return redirect('Index?error=' . __('Заявка не найдена'));
        }

        switch ($supportTicketStatus) {
            case 'На рассмотрении':
                $redirectTo = 'Index?messageokay=' . __('Ваша заявка на рассмотрении');
                break;
            case 'Одобрена':
                $redirectTo = 'Index?message=' . __('Ваша заявка одобрена');
                break;
            case 'Отклонена':
                $redirectTo = 'Index?error=' . __('Ваша заявка отклонена');
                break;
            default:
                return redirect('Index?error=' . __('Заявка не найдена'));
                break;
        }

        return redirect($redirectTo);
    }

    public static function excelExport($comingFrom)
    {
        $lastSegment = basename($comingFrom);

        switch ($lastSegment) {
            case 'supporttickets_underReview':
                $supportTicketsStatus = 'Заявки_на_рассмотрении';

                $supportTickets = SupportTicket::where('supportTicketStatus', 'На рассмотрении')->get();
                break;
            case 'supporttickets_approved':
                $supportTicketsStatus = 'Одобренные_заявки';

                $supportTickets = SupportTicket::where('supportTicketStatus', 'Одобрена')->get();
                break;
            case 'supporttickets_rejected':
                $supportTicketsStatus = 'Отклонённые_заявки';

                $supportTickets = SupportTicket::where('supportTicketStatus', 'Отклонена')->get();
                break;
            default:
                $supportTicketsStatus = 'Все_заявки';

                $supportTickets = SupportTicket::all();
                break;
        }

        // First row values/column names
        $data = [[
            "ID заявки",
            "ФИО",
            "Вид теста",
            "Курс",
            "Отделение",
            "Дисциплина",
            "Email",
            "Телефон",
            "Дополнительная информация",
            "Причина",
            "Статус",
            "Дата подачи завяки",
        ]];

        foreach ($supportTickets as $item) {
            array_push($data, [
                $item->id,
                $item->fullName,
                $item->testType,
                $item->course,
                $item->department,
                $item->subject,
                $item->email,
                $item->phoneNumber,
                $item->extraTextInfo,
                $item->reason,
                $item->supportTicketStatus,
                $item->created_at,
            ]);
        }

        $export = new SupportTicketsExport([$data]);

        $filename = date('Y-m-d') . '_HatAlmasu_' . $supportTicketsStatus;

        return Excel::download($export, $filename . '.xlsx');
    }
}

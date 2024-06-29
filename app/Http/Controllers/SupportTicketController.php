<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SiteSettings;

use App\Exports\RequestsExport;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SupportTicketController extends Controller
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

                $filePathWithoutPublic = str_replace('public/', '', $filePath);
                $filePaths[] = $filePathWithoutPublic;
                $jsonFilePaths = json_encode($filePaths);
            }
            //Image save and checking size (Currently 10MB)
            // $uploadedFile = $request->file(' ')->getRealPath();
            // if (filesize($uploadedFile) > 10485760) {
            //     return redirect('Index?error=Файл слишком большой');
            // }
            // clearstatcache();
            // $bin_string = file_get_contents($image->getRealPath());
            // $confirmationFile = base64_encode($bin_string);
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

        $requestID = DB::getPdo()->lastInsertId();

        Session::put('lastRequestTime', date('d-m-Y h:i:s'));

        return redirect('Index?message=' . __('Вы успешно подали заявку, ваш номер заявки: ')  . $requestID . __('. Сохраните этот номер!'));
    }

    public function image(int $requestID)
    {
        return view('RequestImage', ['image' => SupportTicket::image($requestID)]);
    }

    public function sendNew()
    {
        $canSendRequests = SiteSettings::canSendRequests();
        if (!$canSendRequests) {
            return redirect('/Index?error=Сейчас нельзя подавать новые заявки');
        }

        return view('SupportTicketNew');
    }

    public function showApprovedSupportTickets()
    {
        $filteredRows = SupportTicket::get();

        // Pass the rows to a view
        return view('bread.browse', compact('filteredRows'));
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

    //     public function excelExportAll(string $statusType)
    //     {
    //         $data = [[
    //             "ID заявки", "ID теста", "Институт", "ФИО", "Специальность", "Курс",
    //             "Отделение", "Дисциплина", "Email", "Телефон", "Причина", "Вид Экзамена"
    //         ]];
    // 
    //         $result = SupportTicket::all($statusType, SiteSettings::currentExamSessionID());
    // 
    //         foreach ($result as $item) {
    //             array_push($data, [
    //                 $item->requestID,
    //                 $item->idOfTest,
    //                 $item->faculty,
    //                 $item->fullName,
    //                 $item->speciality,
    //                 $item->course,
    //                 $item->department,
    //                 $item->subject,
    //                 $item->mail,
    //                 $item->phoneNumber,
    //                 $item->reason,
    //                 $item->examType,
    //             ]);
    //         }
    // 
    //         $export = new RequestsExport([$data]);
    // 
    //         $filename = date('Y-m-d') . '_Requests_' . ucfirst($statusType) . '_All';
    // 
    //         return Excel::download($export, $filename . '.xlsx');
    //     }
    // 
    //     public function excelExport(string $statusType, int $currentPage)
    //     {
    //         $perPage = $this->perPagePrivate;
    // 
    //         $data = [[
    //             "ID заявки", "ID теста", "Институт", "ФИО", "Специальность", "Курс",
    //             "Отделение", "Дисциплина", "Email", "Телефон", "Причина", "Вид Экзамена"
    //         ]];
    // 
    //         $result = SupportTicket::page($statusType, $perPage, $currentPage, SiteSettings::currentExamSessionID());
    // 
    //         foreach ($result as $item) {
    //             array_push($data, [
    //                 $item->requestID,
    //                 $item->idOfTest,
    //                 $item->faculty,
    //                 $item->fullName,
    //                 $item->speciality,
    //                 $item->course,
    //                 $item->department,
    //                 $item->subject,
    //                 $item->mail,
    //                 $item->phoneNumber,
    //                 $item->reason,
    //                 $item->examType,
    //             ]);
    //         }
    // 
    //         $export = new RequestsExport([$data]);
    // 
    //         $filename = date('Y-m-d') . '_Requests_' . ucfirst($statusType) . '_Page_' . $currentPage + 1;
    // 
    //         return Excel::download($export, $filename . '.xlsx');
    //     }
}

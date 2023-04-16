<?php

namespace App\Http\Controllers;

use App\Models\Options;
use App\Models\Requests;
use App\Models\SiteSettings;

use App\Exports\RequestsExport;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;

class RequestsController extends Controller
{
    private $perPagePrivate = 100;

    public function page($statusType, $currentPage)
    {
        $requestsTitle = array("new" => "Новые заявки", "approved" => "Одобренные заявки", "rejected" => "Отклонённые заявки");

        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = Requests::page($statusType, $perPage, $currentPage, SiteSettings::currentExamSessionID());

        return view('RequestsView', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
            'statusType' => $statusType, 'requestsTitle' => $requestsTitle[$statusType],
        ]);
    }

    public function search(Request $request)
    {
        if ($request->searchRequest == '') {
            $perPage = $this->perPagePrivate;

            $result = Requests::page($request->statusType, $perPage, $request->currentPage, SiteSettings::currentExamSessionID());
        } else {
            $result = Requests::search($request->statusType, $request->searchRequest, $request->searchType, SiteSettings::currentExamSessionID());
        }

        $html = '';
        foreach ($result as $value) {
            $html .= '<tr><td>' . $value->requestID . '</td>';
            $html .= '<td>' . $value->idOfTest . '</td>';
            $html .= '<td>' . $value->department . '</td>';
            $html .= '<td>' . $value->course . '</td>';
            $html .= '<td>' . $value->fullName . '</td>';
            $html .= '<td>' . $value->faculty . '</td>';
            $html .= '<td>' . $value->speciality . '</td>';
            $html .= '<td>' . $value->subject . '</td>';
            $html .= '<td>' . $value->mail . '</td>';
            $html .= '<td>' . $value->phoneNumber . '</td>';
            $html .= '<td>' . $value->reason . '</td>';
            $html .= '<td>' . $value->examType . '</td>';
            $html .= '<td><button type="button" target="_blank" onclick="window.open(&#39/Requests/Image/' . $value->requestID . '&#39)" class="button-image-view">Перейти</button></td>';
            if (in_array(Auth::user()->user_privilege, ['Admin', 'Support'])) {
                $html .= '<td>';
                if (in_array($request->statusType, ['new', 'rejected'])) {
                    $html .= '<button type="button" target="_blank" onclick="window.location=(&#39/Requests/ChangeStatus/' .
                        $value->requestID . '/1&#39)" class="button-approve">✓</button>';
                }
                if (in_array($request->statusType, ['new', 'approved'])) {
                    $html .= '<button type="button" target="_blank" onclick="window.location=(&#39/Requests/ChangeStatus/' .
                        $value->requestID . '/3&#39)" class="button-reject">X</button>';
                }
                $html .=   '</td>';
            }
            $html .= '</tr>';
        }

        return $html;
    }

    public function changeStatus(int $requestID, int $requestStatus)
    {
        $dbRequestStatus = Requests::requestStatus($requestID);

        if ($dbRequestStatus->requestStatus == 2) {
            return redirect('/Index?error=Нельзя изменить статус заявки, так как студент уже выбрал дату пересдачи');
        }

        Requests::updateTo($requestID, $requestStatus);

        return redirect()->back();
    }

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
                'idOfTest' => [
                    'required', Rule::unique('requests', 'idOfTest')
                ],
                'course' => 'required',
                'faculty' => 'required',
                'department' => 'required',
                'speciality' => 'required',
                'subject' => 'required',
                'mail' => ['required', 'email'],
                'phoneNumber' => 'required',
                'reason' => 'required',
                'examType' => 'required',
                'confirmationFile' => 'required'
            ]
        );

        $fullName = $request->input('fullName');
        $idOfTest = $request->input('idOfTest');
        $faculty = $request->input('faculty');
        $course = $request->input('course');
        $department = $request->input('department');
        $speciality = $request->input('speciality');
        $subject = $request->input('subject');
        $mail = $request->input('mail');
        $phoneNumber = $request->input('phoneNumber');
        $reason = $request->input('reason');
        $examType = $request->input('examType');
        $image = $request->file('confirmationFile');

        //Image save and checking size (Currently 10MB)
        $uploadedFile = $image->getRealPath();
        if (filesize($uploadedFile) > 10485760) {
            return redirect('Index?error=Файл слишком большой');
        }
        clearstatcache();
        $bin_string = file_get_contents($image->getRealPath());
        $confirmationFile = base64_encode($bin_string);

        $data = array(
            'fullName' => $fullName, 'idOfTest' => $idOfTest, 'faculty' => $faculty, 'course' => $course,
            'department' => $department, 'speciality' => $speciality, 'subject' => $subject, 'mail' => $mail, 'phoneNumber' => $phoneNumber,
            'reason' => $reason, 'examType' => $examType, 'confirmationFile' => $confirmationFile, 'examSessionID' => SiteSettings::currentExamSessionID()
        );

        Requests::insert($data);

        $requestID = DB::getPdo()->lastInsertId();

        Session::put('lastRequestTime', date('d-m-Y h:i:s'));

        return redirect('Index?message=' . __('Вы успешно подали заявку, ваш номер заявки: ')  . $requestID . __('. Сохраните этот номер!'));
    }

    public function image(int $requestID)
    {
        return view('RequestImage', ['image' => Requests::image($requestID)]);
    }

    public function sendNew()
    {
        $canSendRequests = SiteSettings::canSendRequests();
        if (!$canSendRequests) {
            return redirect('/Index?error=Сейчас нельзя подавать новые заявки');
        }

        return view('RequestNew', ['options' => Options::options()]);
    }

    public function excelExportAll(string $statusType)
    {
        $data = [[
            "ID заявки", "ID теста", "Институт", "ФИО", "Специальность", "Курс",
            "Отделение", "Дисциплина", "Email", "Телефон", "Причина", "Вид Экзамена"
        ]];

        $result = Requests::all($statusType, SiteSettings::currentExamSessionID());

        foreach ($result as $item) {
            array_push($data, [
                $item->requestID,
                $item->idOfTest,
                $item->faculty,
                $item->fullName,
                $item->speciality,
                $item->course,
                $item->department,
                $item->subject,
                $item->mail,
                $item->phoneNumber,
                $item->reason,
                $item->examType,
            ]);
        }

        $export = new RequestsExport([$data]);

        $filename = date('Y-m-d') . '_Requests_' . ucfirst($statusType) . '_All';

        return Excel::download($export, $filename . '.xlsx');
    }

    public function excelExport(string $statusType, int $currentPage)
    {
        $perPage = $this->perPagePrivate;

        $data = [[
            "ID заявки", "ID теста", "Институт", "ФИО", "Специальность", "Курс",
            "Отделение", "Дисциплина", "Email", "Телефон", "Причина", "Вид Экзамена"
        ]];

        $result = Requests::page($statusType, $perPage, $currentPage, SiteSettings::currentExamSessionID());

        foreach ($result as $item) {
            array_push($data, [
                $item->requestID,
                $item->idOfTest,
                $item->faculty,
                $item->fullName,
                $item->speciality,
                $item->course,
                $item->department,
                $item->subject,
                $item->mail,
                $item->phoneNumber,
                $item->reason,
                $item->examType,
            ]);
        }

        $export = new RequestsExport([$data]);

        $filename = date('Y-m-d') . '_Requests_' . ucfirst($statusType) . '_Page_' . $currentPage + 1;

        return Excel::download($export, $filename . '.xlsx');
    }
}

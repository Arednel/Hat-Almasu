<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use App\Exports\RequestsExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class RequestsController extends Controller
{
    private $perPagePrivate = 100;

    private function requests($statusType, $requestsTitle, $currentPage)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            $perPage = $this->perPagePrivate;

            $offSet = $currentPage * $perPage;
            $pageStart = $offSet + 1;
            $pageEnd = $pageStart + $perPage - 1;

            $result = Requests::{$statusType . 'Page'}($perPage, $currentPage);

            return view('Requests', [
                'result' => $result, 'currentPage' => $currentPage,
                'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
                'statusType' => $statusType, 'requestsTitle' => $requestsTitle,
            ]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function new(int $currentPage)
    {
        return $this->requests('new', 'Новые заявки', $currentPage);
    }

    public function approved(int $currentPage)
    {
        return $this->requests('approved', 'Одобренные заявки', $currentPage);
    }

    public function rejected(int $currentPage)
    {
        return $this->requests('rejected', 'Отклонённые заявки', $currentPage);
    }

    public function changeStatus(int $requestID, int $requestStatus)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support'])) {
            return Requests::updateTo($requestID, $requestStatus);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function insert(Request $request)
    {
        //Limitation of request amount (one request per 3 minutes)
        if (null !== Session::get('lastRequestTime')) {
            $currentFullTime = date('d-m-Y h:i:s');
            $to_time = strtotime(Session::get('lastRequestTime'));
            $from_time = strtotime($currentFullTime);
            $diffirenceBetweenTime = round(abs($to_time - $from_time) / 60, 2);
            if ($diffirenceBetweenTime < 3) {
                return redirect('Index?error=Подождите 3 минуты, перед подачей следующей заявки');
            }
        }

        //Data validation
        $request->validate(
            [
                'fullName' => 'required',
                'idOfTest' => [
                    'required'
                    //, Rule::unique('requests', 'idOfTest')
                ],
                'course' => 'required',
                'faculty' => 'required',
                'department' => 'required',
                'speciality' => 'required',
                'subject' => 'required',
                'mail' => ['required', 'email'],
                'phoneNumber' => 'required',
                'reason' => 'required',
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
        $image = $request->file('confirmationFile');

        //Image save and checking size (Currently 10MB)
        $uploadedFile = $image->getRealPath();
        if (filesize($uploadedFile) > 1048576) {
            return redirect('Index?error=Файл слишком большой');
        }
        clearstatcache();
        $bin_string = file_get_contents($image->getRealPath());
        $confirmationFile = base64_encode($bin_string);

        $data = array(
            'fullName' => $fullName, "idOfTest" => $idOfTest, "faculty" => $faculty, "course" => $course,
            "department" => $department, "speciality" => $speciality, "subject" => $subject, "mail" => $mail, "phoneNumber" => $phoneNumber,
            "reason" => $reason, "confirmationFile" => $confirmationFile
        );

        Requests::insert($data);

        $requestID = DB::getPdo()->lastInsertId();

        Session::put('lastRequestTime', date('d-m-Y h:i:s'));

        return redirect('Index?message=Вы успешно подали заявку, ваш номер заявки: ' . $requestID . '   Сохраните этот номер!');
    }

    public function image(int $requestID)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            return view('RequestImage', ['image' => Requests::image($requestID)]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function excelExportAll(string $statusType)
    {
        $data = [[
            "ID заявки", "ID теста", "Институт", "ФИО", "Специальность",
            "Курс", "Отделение", "Дисциплина", "Email", "Телефон", "Причина"
        ]];

        $result = Requests::{$statusType . 'All'}();

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
            "ID заявки", "ID теста", "Институт", "ФИО", "Специальность",
            "Курс", "Отделение", "Дисциплина", "Email", "Телефон", "Причина"
        ]];

        $result = Requests::{$statusType . 'Page'}($perPage, $currentPage);

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
            ]);
        }

        $export = new RequestsExport([$data]);

        $filename = date('Y-m-d') . '_Requests_' . ucfirst($statusType) . '_Page_' . $currentPage + 1;

        return Excel::download($export, $filename . '.xlsx');
    }
}

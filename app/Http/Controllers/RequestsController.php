<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RequestsController extends Controller
{
    private function allRequests($statusType, $requestsTitle, $currentPage, $requestTypeOne, $requestTypeTwo)
    {
        $perPage = 100;

        Session::put('statusType', $statusType);
        Session::put('requestsTitle', $requestsTitle);

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = DB::table('requests')->where('isApproved', $requestTypeOne)
            ->orWhere('isApproved', $requestTypeTwo)
            ->orderBy('requestID')
            ->limit($perPage)
            ->offset($offSet)
            ->select(array(
                'requestID',
                'fullName', 'idOfTest', 'faculty',
                'speciality', 'course', 'department', 'subject',
                'mail', 'phoneNumber', 'reason', 'isApproved'
            ))
            ->get();

        return view('Requests', ['result' => $result, 'currentPage' => $currentPage, 'pageStart' => $pageStart, 'pageEnd' => $pageEnd,]);
    }

    public function new(int $currentPage)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            return $this->allRequests('new', 'Новые заявки', $currentPage, 0, 0);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function approved(int $currentPage)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            return $this->allRequests('approved', 'Одобренные заявки', $currentPage, 1, 2);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function rejected(int $currentPage)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            return $this->allRequests('rejected', 'Отклонённые заявки', $currentPage, 5, 5);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }
}

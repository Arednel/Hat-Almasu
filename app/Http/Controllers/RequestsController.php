<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RequestsController extends Controller
{
    private function requests($statusType, $requestsTitle, $currentPage, $requestStatusOne, $requestStatusTwo)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            $perPage = 100;

            Session::put('statusType', $statusType);
            Session::put('requestsTitle', $requestsTitle);

            $offSet = $currentPage * $perPage;
            $pageStart = $offSet + 1;
            $pageEnd = $pageStart + $perPage - 1;

            $result = DB::table('requests')
                ->where('requestStatus', $requestStatusOne)
                ->orWhere('requestStatus', $requestStatusTwo)
                ->orderBy('requestID')
                ->limit($perPage)
                ->offset($offSet)
                ->select(array(
                    'requestID',
                    'fullName', 'idOfTest', 'faculty',
                    'speciality', 'course', 'department', 'subject',
                    'mail', 'phoneNumber', 'reason', 'requestStatus'
                ))
                ->get();

            return view('Requests', ['result' => $result, 'currentPage' => $currentPage, 'pageStart' => $pageStart, 'pageEnd' => $pageEnd,]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function new(int $currentPage)
    {
        return $this->requests('new', 'Новые заявки', $currentPage, 0, 0);
    }

    public function approved(int $currentPage)
    {
        return $this->requests('approved', 'Одобренные заявки', $currentPage, 1, 2);
    }

    public function rejected(int $currentPage)
    {
        return $this->requests('rejected', 'Отклонённые заявки', $currentPage, 3, 3);
    }

    public function changeStatus(int $requestID, int $requestStatus)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support'])) {
            $databaseRequestStatus = DB::table('requests')
                ->where('requestID', $requestID)
                ->select('requestStatus')
                ->first();

            if ($databaseRequestStatus->requestStatus == 2) {
                return redirect('/Index?error=Нельзя изменить статус заявки, так как студент уже выбрал дату пересдачи');
            }

            DB::table('requests')
                ->where('requestID', $requestID)
                ->update(['requestStatus' => $requestStatus]);

            return redirect()->back();
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function image(int $requestID)
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            $image = DB::table('requests')
                ->where('requestID', $requestID)
                ->select('confirmationFile')
                ->first();

            return view('RequestImage', ['image' => $image]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }
}

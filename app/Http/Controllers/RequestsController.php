<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RequestsController extends Controller
{
    public function new()
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            Session::put('statusType', 'new');
            Session::put('requestsTitle', 'Новые заявки');

            $result = DB::table('requests')->where('isApproved', 0)
                ->orderBy('requestID')
                // ->limit(0)
                // ->offset(0)
                ->select(array(
                    'requestID',
                    'fullName', 'idOfTest', 'faculty',
                    'speciality', 'course', 'department', 'subject',
                    'mail', 'phoneNumber', 'reason', 'isApproved'
                ))
                ->get();

            return view('Requests', ['result' => $result]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function approved()
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            Session::put('statusType', 'approved');
            Session::put('requestsTitle', 'Одобренные заявки');

            $result = DB::table('requests')->where('isApproved', 1)
                ->orWhere('isApproved', 2)
                ->orderBy('requestID')
                // ->limit(0)
                // ->offset(0)
                ->select(array(
                    'requestID',
                    'fullName', 'idOfTest', 'faculty',
                    'speciality', 'course', 'department', 'subject',
                    'mail', 'phoneNumber', 'reason', 'isApproved'
                ))
                ->get();

            return view('Requests', ['result' => $result]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }

    public function rejected()
    {
        if (in_array(Session::get('userPrivilege'), ['Admin', 'Support', 'Viewer'])) {
            Session::put('statusType', 'rejected');
            Session::put('requestsTitle', 'Отклонённые заявки');

            $result = DB::table('requests')->where('isApproved', 5)
                ->orderBy('requestID')
                // ->limit(0)
                // ->offset(0)
                ->select(array(
                    'requestID',
                    'fullName', 'idOfTest', 'faculty',
                    'speciality', 'course', 'department', 'subject',
                    'mail', 'phoneNumber', 'reason', 'isApproved'
                ))
                ->get();

            return view('Requests', ['result' => $result]);
        } else {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }
    }
}

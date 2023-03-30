<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\ExamSessions;
use App\Models\SiteSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExamSessionsController extends Controller
{
    private $perPagePrivate = 100;

    public function all()
    {
        $rooms = ExamSessions::all();

        return $rooms;
    }

    public function page(int $currentPage)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = ExamSessions::page($perPage, $currentPage);

        foreach ($result as $value) {
            $requestsAmount = Requests::count($value->examSessionID);
            $value->requestsAmount = $requestsAmount;
        }
        $currentSessionID = SiteSettings::currentExamSessionID();

        return view('ManageExamSessions', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
            'currentExamSessionID' => $currentSessionID->currentExamSessionID
        ]);
    }

    public function insert()
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        ExamSessions::insert();

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'examSessionID' => 'required'
            ]
        );

        ExamSessions::delete($request->input('examSessionID'));

        return redirect()->back();
    }

    public function changeCurrent(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'examSessionID' => 'required'
            ]
        );

        SiteSettings::setCurrentExamSessionID($request->input('examSessionID'));

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\Rooms;
use App\Models\Requests;
use App\Models\ExamSessions;
use App\Models\SiteSettings;

use Illuminate\Http\Request;

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
        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = ExamSessions::page($perPage, $currentPage);
        foreach ($result as $value) {
            $requestsAmount = Requests::count($value->examSessionID);
            $datesAmount = Dates::count($value->examSessionID);
            $roomsAmount = Rooms::count($value->examSessionID);
            $value->requestsAmount = $requestsAmount;
            $value->datesAmount = $datesAmount;
            $value->roomsAmount = $roomsAmount;
        }
        $currentSessionID = SiteSettings::currentExamSessionID();

        return view('ManageExamSessions', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
            'currentExamSessionID' => $currentSessionID
        ]);
    }

    public function insert()
    {
        ExamSessions::insert();

        return redirect()->back();
    }

    public function delete(Request $request)
    {
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
        $request->validate(
            [
                'examSessionID' => 'required'
            ]
        );

        SiteSettings::setCurrentExamSessionID($request->input('examSessionID'));

        return redirect()->back();
    }
}

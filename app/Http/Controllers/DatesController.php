<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\SiteSettings;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

class DatesController extends Controller
{
    private $perPagePrivate = 100;

    public function page(int $currentPage)
    {
        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = Dates::page($perPage, $currentPage);

        return view('ManageDates', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate(
            [
                'date' => [
                    'required', 'date', Rule::unique('availabledates', 'date')
                ],
                'startHour' => 'required',
                'endHour' => 'required',
            ]
        );

        $date = $request->input('date');
        $startHour = $request->input('startHour');
        $endHour = $request->input('endHour');
        if ($startHour > $endHour) {
            $startHour = $endHour - 1;
        }
        if ($request->input('isOnline') != null) {
            $isOnline = $request->input('isOnline');
        } else {
            $isOnline = false;
        }

        $data = array(
            'date' => $date, 'startHour' => $startHour, 'endHour' => $endHour, 'isOnline' => $isOnline, 'examSessionID' => SiteSettings::currentExamSessionID()
        );

        Dates::insert($data);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $request->validate(
            [
                'date' => [
                    'required', 'date'
                ]
            ]
        );

        Dates::delete($request->input('date'));

        return redirect()->back();
    }
}

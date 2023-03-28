<?php

namespace App\Http\Controllers;

use App\Models\Sessions;
use App\Models\SiteSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionsController extends Controller
{
    private $perPagePrivate = 100;

    public function all()
    {
        $rooms = Sessions::all();

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

        $result = Sessions::page($perPage, $currentPage);
        $currentSessionID = SiteSettings::currentSessionID();

        return view('ManageSessions', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
            'currentSessionID' => $currentSessionID->currentSessionID
        ]);
    }

    public function insert(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'sessionStart' => ['required', 'date'],
                'sessionEnd' => ['required', 'date']
            ]
        );

        $sessionStart = $request->input('sessionStart');
        $sessionEnd = $request->input('sessionEnd');

        if ($sessionStart > $sessionEnd) {
            $sessionStart = date('Y-m-d', strtotime($sessionEnd . ' - 1 days'));
        }

        $data = array(
            'sessionStart' => $sessionStart, 'sessionEnd' => $sessionEnd
        );

        Sessions::insert($data);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'sessionID' => 'required'
            ]
        );

        Sessions::delete($request->input('sessionID'));

        return redirect()->back();
    }

    public function changeCurrent(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'sessionID' => 'required'
            ]
        );

        SiteSettings::setCurrentSession($request->input('sessionID'));

        return redirect()->back();
    }
}

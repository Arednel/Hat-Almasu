<?php

namespace App\Http\Controllers;

use App\Models\Rooms;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class RoomsController extends Controller
{
    private $perPagePrivate = 100;

    public function all()
    {
        $rooms = Rooms::all();

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

        $result = Rooms::page($perPage, $currentPage);

        return view('ManageRooms', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
        ]);
    }

    public function insert(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'roomName' => 'required',
                'roomSpace' => 'required',
            ]
        );

        $roomName = $request->input('roomName');
        $roomSpace = $request->input('roomSpace');

        $data = array(
            'roomName' => $roomName, 'roomSpace' => $roomSpace
        );

        Rooms::insert($data);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'roomID' => 'required'
            ]
        );

        $roomID = $request->input('roomID');
        $roomName = $request->input('roomName');
        $roomSpace = $request->input('roomSpace');

        if ($roomName != null) {
            Rooms::updateRoomName($roomID, $roomName);
        }
        if ($roomSpace != null) {
            Rooms::updateRoomSpace($roomID, $roomSpace);
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'roomID' => 'required'
            ]
        );

        Rooms::delete($request->input('roomID'));

        return redirect()->back();
    }
}

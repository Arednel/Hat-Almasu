<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    private $perPagePrivate = 100;

    public function page(int $currentPage)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = Users::page($perPage, $currentPage);

        return view('ManageUsers', [
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
                'userName' => 'required',
                'userPassword' => 'required',
                'userPrivilege' => 'required'
            ]
        );

        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');
        $userPrivilege = $request->input('userPrivilege');

        $data = array(
            'userName' => $userName, 'userPassword' => $userPassword,
            'userPrivilege' => $userPrivilege, 'userPassword' => $userPassword
        );

        Users::insert($data);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        if (!(in_array(Session::get('userPrivilege'), ['Admin']))) {
            return redirect('/Index?error=У вас недостаточный уровень доступа!');
        }

        $request->validate(
            [
                'userID' => 'required'
            ]
        );

        $userID = $request->input('userID');
        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');
        $userPrivilege = $request->input('userPrivilege');

        if ($userName != null) {
            Users::updateUserName($userID, $userName);
        }
        if ($userPassword != null) {
            Users::updateUserPassword($userID, $userPassword);
        }
        if ($userPrivilege != null) {
            Users::updateUserPrivilege($userID, $userPrivilege);
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
                'userID' => 'required'
            ]
        );

        Users::delete($request->input('userID'));

        return redirect()->back();
    }
}

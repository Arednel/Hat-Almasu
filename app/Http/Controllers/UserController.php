<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    private $perPagePrivate = 100;

    public function page(int $currentPage)
    {
        $perPage = $this->perPagePrivate;

        $offSet = $currentPage * $perPage;
        $pageStart = $offSet + 1;
        $pageEnd = $pageStart + $perPage - 1;

        $result = User::page($perPage, $currentPage);

        return view('ManageUsers', [
            'result' => $result, 'currentPage' => $currentPage,
            'pageStart' => $pageStart, 'pageEnd' => $pageEnd,
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate(
            [
                'userName' => 'required',
                'password' => 'required',
                'userPrivilege' => 'required'
            ]
        );

        $userName = $request->input('userName');
        $password = Hash::make($request->input('password'));
        $userPrivilege = $request->input('userPrivilege');

        $data = array(
            'userName' => $userName, 'password' => $password,
            'userPrivilege' => $userPrivilege, 'password' => $password
        );

        user::insert($data);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'id' => 'required'
            ]
        );

        $id = $request->input('id');
        $userName = $request->input('userName');
        $password = $request->input('password');

        $userPrivilege = $request->input('userPrivilege');

        if ($userName != null) {
            $request->validate(
                [
                    'userName' => Rule::unique('users', 'userName'),
                ]
            );
            user::updateUserName($id, $userName);
        }
        if ($password != null) {
            $passwordHash = Hash::make($password);
            user::updatePassword($id, $passwordHash);
        }
        if ($userPrivilege != null) {
            user::updateUserPrivilege($id, $userPrivilege);
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $request->validate(
            [
                'id' => 'required'
            ]
        );

        if (Auth::user()->id == $request->input('id')) {
            return redirect('Index?error=Вы патаетесь удалить своего пользователя!');
        }

        user::deleteUser($request->input('id'));

        return redirect()->back();
    }
}

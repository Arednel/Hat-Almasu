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
                'username' => 'required',
                'password' => 'required',
                'user_privilege' => 'required'
            ]
        );

        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $user_privilege = $request->input('user_privilege');

        $data = array(
            'username' => $username, 'password' => $password,
            'user_privilege' => $user_privilege, 'password' => $password
        );

        User::insert($data);

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
        $username = $request->input('username');
        $password = $request->input('password');

        $user_privilege = $request->input('user_privilege');

        if ($username != null) {
            $request->validate(
                [
                    'username' => Rule::unique('users', 'username'),
                ]
            );
            User::updateUserName($id, $username);
        }
        if ($password != null) {
            $passwordHash = Hash::make($password);
            User::updatePassword($id, $passwordHash);
        }
        if ($user_privilege != null) {
            User::updateUserPrivilege($id, $user_privilege);
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

        User::deleteUser($request->input('id'));

        return redirect()->back();
    }
}

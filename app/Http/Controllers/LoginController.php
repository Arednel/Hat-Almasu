<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //Validation of user input
        $formFields = $request->validate(
            [
                'userName' => 'required',
                'userPassword' => 'required'
            ]
        );

        function validateData($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }
        $userName = validateData($request->input('userName'));
        $inputedPassword = validateData($request->input('userPassword'));

        //Validation from Database
        if ($dbPassword = DB::table('users')->where('userName', $userName)->value('userPassword')) {
            if ($inputedPassword == $dbPassword) {
                $result = DB::table('users')->where('userName', $userName)
                    ->select(array('userID', 'userPrivilege'))
                    ->get()
                    ->first();

                Session::put('userName', $userName);
                Session::put('userID', $result->userID);
                Session::put('userPrivilege', $result->userPrivilege);

                return redirect('Index?message=Вы успешно авторизовались как: ' . $userName);
            } else {
                return redirect('Login?error=Неверный логин или пароль');
            }
        } else {
            return redirect('Login?error=Неверный логин или пароль');
        }
    }

    public function logout(Request $request)
    {
        Session::flush();

        return redirect('/');
    }
}

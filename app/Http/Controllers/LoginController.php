<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'userName' => 'required',
                'password' => 'required'
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('Index?message=Вы успешно авторизовались как: ' . Auth::user()->userName);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Servises\UserServise;

class LoginController extends Controller
{
    /**
     * Отображение страницы авторизации
     */
    public function login(){
        return view('auth.login');
    }

    /**
     * Авторизация пользователя
     * @param LoginRequest $request
     */
    public function makeLogin(LoginRequest $request)
    {
        if (UserServise::login(
            $request->email,
            $request->password,
            $request->remember
        )) {
            request()->session()->regenerate();

            return redirect()->route('homepage');
        }

        Flash('Указан неверный логин или пароль.')->error();

        return redirect()->route('login');
    }
}

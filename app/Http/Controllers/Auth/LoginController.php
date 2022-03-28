<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Validator;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashNotifier;

class LoginController extends Controller
{
    /**
     * Отображение страницы авторизации
     */
    public function showLogin(){
        return view('auth.login');
    }

    /**
     * Авторизация пользователя
     * @param LoginRequest $request
     */
    public function makeLogin(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            $request->session()->regenerate();

            return Redirect::to(route('homepage'));
        }

        Flash('Указан неверный логин или пароль.')->error();

        return Redirect::to('/login');
    }
}

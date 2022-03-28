<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Servises\UserServise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class RegistrationController extends Controller
{
    /**
     * Отображение страницы регистрации
     */
    public function showRegistration()
    {
        return view('auth.registration');
    }

    /**
     * Регистрация нового пользователя
     * @param NewUserRequest $request
     */
    public function registrate(NewUserRequest $request)
    {
        UserServise::create();

        flash('Вы успешно зарегистрированы!')->success();

        return Redirect::to('/login');
    }
}

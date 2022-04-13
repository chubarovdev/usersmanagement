<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
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
        User::make();

        flash('Вы успешно зарегистрированы!')->success();

        return redirect()->route('login');
    }
}

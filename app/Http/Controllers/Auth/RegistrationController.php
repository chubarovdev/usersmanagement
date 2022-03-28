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
    public function showRegistration()
    {
        return view('auth.registration');
    }

    public function registrate(NewUserRequest $request)
    {
        UserServise::create();

        flash('Вы успешно зарегистрированы!')->success();

        return Redirect::to('/login');
    }
}

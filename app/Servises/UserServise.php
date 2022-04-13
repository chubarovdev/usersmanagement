<?php

namespace App\Servises;

use Illuminate\Support\Facades\Auth;

class UserServise
{
    public static function login($email, $password, $remember = false)
    {
        return Auth::attempt(['email' => $email, 'password' => $password], $remember);
    }
}

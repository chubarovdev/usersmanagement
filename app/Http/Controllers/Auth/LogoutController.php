<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Выход пользователя из системы
     */
    public function make()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

}

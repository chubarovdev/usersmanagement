<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
use App\Servises\AvatarServise;
use App\Servises\UserServise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Отображение страницы создания нового пользователя
     */
    public function newUser()
    {
        return view('admin.create');
    }

    /**
     * Создание нового пользователя
     * @param NewUserRequest $request
     */
    public function storeNewUser(NewUserRequest $request)
    {
       UserServise::create();

        flash('Пользователь успешно создан!')->success();

       return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecurityRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\StoreAvatarRequest;
use App\Models\User;
use App\Rules\EmptyInput;
use App\Rules\EmptyString;
use App\Servises\AvatarServise;
use App\Servises\UserServise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Обображение главной страницы со всеми пользователями
     */
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(6);

        $users->withPath('/users');
        foreach ($users as $user) {

        }

        if( Auth::check() )
        {
            $authUser = auth()->user();
            $authUserId = $authUser->id;
            $authUserRole = $authUser->role;
        } else {
            $authUserId = null;
            $authUserRole = null;
        }

        return view('homepage', ['authUserId' => $authUserId, 'authUserRole' => $authUserRole, 'users' => $users]);
    }

    /**
     * Отображение профиля пользователя
     * @param User $user
     */
    public function profile(User $user)
    {
        $user->avatar = AvatarServise::show($user);

        return view('profile.profile', ['user' => $user]);
    }

    public function mainInfo(User $user)
    {
        return view('profile.edit', ['user' => $user]);
    }


    public function storeMainInfo(User $user, Request $request)
    {
        $user->name = $request->name;
        $user->job = $request->job;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        flash('Данные успешно обновлены!')->success();
        return redirect()->back();
    }

    public function security(User $user)
    {
        return view('profile.security', ['user' => $user]);
    }

    public function storeSecurity(User $user, SecurityRequest $request)
    {
        $isEmailChanged = UserServise::updateEmail($user, $request->email);

        if($isEmailChanged) {
            flash('E-mail успешно обновлен!')->success();
        }

        $isPasswordChanged = UserServise::updatePassword($user, $request->password);

        if($isPasswordChanged) {
            flash('Пароль успешно обновлен!')->success();
        }

        return redirect()->back();
    }

    public function avatar(User $user)
    {
        $user->avatar = AvatarServise::show($user);
        return view('profile.avatar', ['user' => $user]);
    }

    public function storeAvatar(User $user, StoreAvatarRequest $request)
    {
        AvatarServise::store($user, $request->avatar);

        flash('Изображение успешно загружено!')->success();

        return redirect()->back();
    }

    public function status(User $user)
    {
        return view('profile.status', ['user' => $user]);
    }

    public function storeStatus(User $user, StatusRequest $request)
    {
        $user->status = $request->status;
        $user->save();

        flash('Статус успешно обновлен!')->success();

        return redirect()->back();
    }

    public function deleteProfile(User $user)
    {
        UserServise::delete($user);

        if( Auth::id() == $user->id ) {
            return redirect()->route('logout');
        }

        flash("Пользователь $user->name удален!")->success();
        return redirect()->back();
    }
}


<?php

namespace App\Servises;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserServise
{
    /**
     * Создание нового пользователя
     * @return mixed
     */
    public static function create()
    {
        $newUser = User::create([
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'name' => request()->name,
            'job' => request()->job,
            'phone' => request()->phone,
            'address' => request()->address,
            'vk_link' => request()->vk_link,
            'telegram_link' => request()->telegram_link,
            'instagram_link' => request()->instagram_link,
            'status' => request()->status,
        ]);

        if(request()->avatar) {
            AvatarServise::store($newUser, request()->avatar);
        }

        return $newUser;
    }

    /**
     * Обновление e-mail пользователя
     * @param User $user
     * @param string $newEmail
     * @return int|void
     */
    public static function updateEmail(User $user, string $newEmail)
    {
        if($newEmail != $user->email) { // Если пользователь вводит свой собственный e-mail
            return DB::table('users')->where('id', $user->id)->update(['email' => $newEmail]);
        }
    }

    /**
     * Обновление пароля пользователя
     * @param User $user
     * @param $newPassword
     * @return int|void
     */
    public static function updatePassword(User $user, $newPassword)
    {
        if(trim($newPassword) != null) { // Обрезаем, если вместо пароля переданы пробелы
            return DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($newPassword)]);
        }
    }

    /**
     * Удаление пользователя вместе с загруженным аватаром
     * @param User $user
     * @return bool|null
     */
    public static function delete(User $user)
    {
        Storage::disk('public')->delete($user->avatar);
        return $user->delete();
    }
}

<?php

namespace App\Servises;

use App\Http\Requests\StoreAvatarRequest;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarServise
{
    /**
     * Сохранение картинки профиля пользователя
     * Удаление старой картинки пользователя, если она была ранее загружена
     * @param User $user
     * @param UploadedFile $image загруженная на сервер картинка
     */
    public static function store(User $user, UploadedFile $image)
    {
        $oldAvatarPath = $user->avatar;

        $newAvatarPath = $image->store('avatars', 'public');

        if($oldAvatarPath != null) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        $user->avatar = $newAvatarPath;
        $user->save();
    }

    /**
     * Вывод картинки пользователя. Если картинки нет, вывод картинки-заглушки
     * @param User $user
     * @return mixed|string
     */
    public static function show(User $user)
    {
        if( ! file_exists($user->avatar)) {
           return 'avatars/default_avatar.png';
        }
        return $user->avatar;
    }
}

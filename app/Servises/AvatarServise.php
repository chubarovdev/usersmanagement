<?php

namespace App\Servises;

use App\Http\Requests\StoreAvatarRequest;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarServise
{
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

    public static function show(User $user)
    {
        if( ! file_exists($user->avatar)) {
           return 'avatars/default_avatar.png';
        }
        return $user->avatar;
    }
}

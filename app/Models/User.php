<?php

namespace App\Models;

use App\Helpers\Status;
use App\Servises\AvatarServise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Integer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'job',
        'phone',
        'address',
        'vk_link',
        'telegram_link',
        'instagram_link',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Создание нового пользователя
     * @return mixed
     */
    public static function make()
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
            'status' => Status::filtrate(request()->status),
        ]);

        if(request()->avatar) {
            AvatarServise::store($newUser, request()->avatar);
        }

        return $newUser;
    }

    /**
     * Обновление пароля пользователя
     * @param User $user
     * @param $password
     * @return int|void
     */
    public static function updatePassword(User $user, $password)
    {
        if(trim($password) != null) { // Обрезаем, если вместо пароля переданы пробелы
            return DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($password)]);
        }
    }

    /**
     * Обновление e-mail пользователя
     * @param User $user
     * @param string $email
     * @return int|void
     */
    public static function updateEmail(User $user, string $email)
    {
        if($email != $user->email) { // Если пользователь вводит свой собственный e-mail
            return DB::table('users')->where('id', $user->id)->update(['email' => $email]);
        }
    }

    public static function updateMainInfo(User $user, $request)
    {
        $user->name = $request->name;
        $user->job = $request->job;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
    }

    /**
     * Обновление статуса пользователя
     */
    public static function updateStatus(User $user, int $status)
    {
        $user->status = $status;
        $user->save();
    }

    /**
     * Удаление пользователя вместе с загруженным аватаром
     * @param User $user
     * @return bool|null
     */
    public static function remove(User $user)
    {
        Storage::disk('public')->delete($user->avatar);

        return $user->delete();
    }
}

<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Класс предназначен для хранения полезных при тестировании методов и функций.
 */
class Tester
{
    public $roles = ['user', 'admin'];

    /**
     * Создание нового пользователя для тестов
     * @param $email
     * @param $password
     * @param string $role
     * @return mixed
     */
    public static function createUser($email, $password, $role = 'user')
    {
        return User::factory()->count(1)->create([
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role
        ])->first();
    }

    /**
     * Авторизация пользователя
     * @param $email
     * @param $password
     * @return bool
     */
    public static function authorizeUser($email, $password)
    {
        return Auth::attempt(['email' => $email, 'password' => $password], false);
    }
}

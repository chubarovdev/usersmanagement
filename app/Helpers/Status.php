<?php

namespace App\Helpers;

class Status
{
    public static $bootstrapStyles = [
        '1' => 'success', // online
        '2' => 'secondary', // offline
        '3' => 'danger' // busy
    ];

    /**
     * Возвращает стиль бутстрапа в соответствии со статусом пользователя.
     * @param int $status
     * @return string
     */
    public static function getBootstrapStyle(int $status) : string
    {
        return self::$bootstrapStyles[$status];
    }

    /**
     * Фильтрация статуса пользователя. Диапазон - целое число от 1 до 3.
     * Возвращает 1, если передано недопустимое значение для статуса.
     * @param $status
     * @return int
     */
    public static function filtrate($status) : int
    {
        return ( ! (is_integer($status) && $status >=1 && $status <=3) ) ? 1 : $status;
    }
}

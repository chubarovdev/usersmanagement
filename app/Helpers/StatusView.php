<?php

namespace App\Helpers;

class StatusView
{
    public static $bootstrapStatusStyles = [
        '1' => 'success', // online
        '2' => 'secondary', // offline
        '3' => 'danger' // busy
    ];
    public static function getBootstrapStyle(int $status) : string
    {
        return self::$bootstrapStatusStyles[$status];
    }
}

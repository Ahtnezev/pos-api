<?php

namespace App\Enums;

enum UserTypes: string {
    case Client = 'client';
    case Vendor = 'vendor';

    public static function __callStatic($name, $arguments)
    {
        return constant("self::$name")->value ?? null;
    }
}

<?php

namespace App\Helper;

class Helper
{
    public static function checkEmail($email): bool{
        $pattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';
        return preg_match($pattern, $email);
    }
}

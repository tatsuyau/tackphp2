<?php

class CSRF
{
    const KEY_NAME = "csrf";

    public static function generate($is_new = false)
    {
        if (!$is_new) {
            if (!empty($_SESSION[self::KEY_NAME])) {
                return $_SESSION[self::KEY_NAME];
            }
        }
        $token = sha1(uniqid(mt_rand(), true));
        $_SESSION[self::KEY_NAME] = $token;

        return $token;
    }

    public static function check($str)
    {
        if (empty($_SESSION[self::KEY_NAME])) {
            return false;
        }
        if ($_SESSION[self::KEY_NAME] != $str) {
            return false;
        }

        return true;
    }
}

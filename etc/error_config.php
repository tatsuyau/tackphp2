<?php

class ErrorConfig
{
    const SYSTEM = -1;
    const PARAM = -11;
    protected static $list = array(
        self::SYSTEM => "システムエラーです。",
        self::PARAM => "不正なパラメーターです。",
    );

    public static function get($code)
    {
        if (empty(self::$list[$code])) {
            $code = self::SYSTEM;
        }
        $message = self::$list[$code] . "[ERRORCODE:" . $code . "]";

        return $message;
    }

    public static function write($code, $message)
    {
        if (!empty(self::$list[$code])) {
            return false;
        }
        self::$list[$code] = $message;

        return true;
    }
}

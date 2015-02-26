<?php

class Html
{
    public static function path($path = null)
    {
        if (!$path) {
            $path = "";
        }
        $url = URL_ROOT . $path;
        echo $url;
    }
}

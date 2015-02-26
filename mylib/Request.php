<?php

class Request
{
    /*
    getParams
    getParam
    getInt
    hasPost
    getPosts
    */
    public static function getParams($method = null)
    {
        $result = array();
        if (!$method || $method == "GET") {
            foreach ((array)$_GET as $key => $val) {
                $result[$key] = $val;
            }
        }
        if (!$method || $method == "POST") {
            foreach ((array)$_POST as $key => $val) {
                $result[$key] = $val;
            }
        }

        return $result;
    }

    public static function getParam($key_name, $method = null)
    {
        $result = null;
        $params = self::getParams($method);
        foreach ($params as $key => $val) {
            if ($key != $key_name) {
                continue;
            }
            $result = $val;
            break;
        }

        return $result;
    }

    public static function getInt($key_name, $method = null)
    {
        $result = self::getParam($key_name, $method);
        if (!$result) {
            return 0;
        }
        if (!is_numeric($result)) {
            return 0;
        }

        return $result;
    }

    public static function hasPost()
    {
        return (!empty($_POST)) ? true : false;
    }
}

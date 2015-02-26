<?php
/*
* よく使うようなシンプルな関数はこちらへ
*/

function h($value, $key = null, $encoding = 'UTF-8')
{
    $str = $value;
    if (is_array($value)) {
        if (empty($key) || empty($value[$key])) {
            $str = "";
        } else {
            $str = $value[$key];
        }
    }
    echo htmlspecialchars($str, ENT_QUOTES, $encoding);
}

function dump($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function debug($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

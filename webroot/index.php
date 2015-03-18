<?php

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', dirname(dirname(__FILE__)) . DS);
//define('URL_ROOT',  "/");
define('URL_ROOT', "/tackphp/");    // add subdirname
define('MY_URL', "http://" . $_SERVER['HTTP_HOST'] . URL_ROOT);
define('CONTROLLER_DIR', APP_ROOT . "controller" . DS);
define('MODEL_DIR', APP_ROOT . "model" . DS);
define('VIEW_DIR', APP_ROOT . "view" . DS);
define('LIB_DIR', APP_ROOT . "mylib" . DS);
define('ETC_DIR', APP_ROOT . "etc" . DS);
define('COMPOSER_DIR', APP_ROOT . "vendor" . DS);
define('LAYOUT_DIR', VIEW_DIR . "layout" . DS);
define('LOG_DIR', APP_ROOT . "log" . DS);
define('ENVIRONMENT', require_once(ETC_DIR . "environment.php"));

spl_autoload_register(function ($class_name) {
    $controller_file = CONTROLLER_DIR . $class_name . ".php";
    if (file_exists($controller_file)) {
        require_once $controller_file;

        return;
    }
    $model_file = MODEL_DIR . $class_name . ".php";
    if (file_exists($model_file)) {
        require_once $model_file;

        return;
    }
    $lib_file = LIB_DIR . $class_name . ".php";
    if (file_exists($lib_file)) {
        require_once $lib_file;

        return;
    }
});

require_once ETC_DIR . "config.php";
require_once ETC_DIR . "error_config.php";
require_once ETC_DIR . "function.php";
require_once ETC_DIR . "database.php";
require_once ETC_DIR . "exceptions.php";
require_once ETC_DIR . "Bootstrap.php";
if (file_exists(COMPOSER_DIR . "autoload.php")) {
    require COMPOSER_DIR . 'autoload.php';
}

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
}

Session::start();

$Bootstrap = new Bootstrap();
$default_controller = "main";
$default_action = "index";
$Bootstrap->dispatch($default_controller, $default_action);

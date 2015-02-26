<?php

class Bootstrap
{
    public $controller_name;
    public $action_name;
    public $args;

    public function dispatch($controller = "main", $action = "index")
    {
        $p = $this->_parseParams($controller, $action);
        $this->controller_name = $p['controller'];
        $this->action_name = $p['action'];
        $this->args = $p['args'];
        try {
            $res = $this->_check();
            if ($res !== true) {
                $res = DEBUG_MODE ? $res : "Page Not Found";
                throw new Exception($res);
            }
            $this->_run();
        } catch (Exception $e) {
            $this->_error($e->getMessage());
        }
    }

    protected function _run()
    {
        $controller_name = $this->controller_name;
        $action_name = $this->action_name;
        $args = $this->args;
        $controller_class = ucwords($controller_name) . "Controller";
        $controllerInst = new $controller_class();
        $controllerInst->controller_name = $controller_name;
        $controllerInst->action_name = $action_name;
        $controllerInst->before();
        call_user_func_array(array($controllerInst, $action_name), $args);
        $controllerInst->after();

        return true;
    }

    protected function _error($message)
    {
        $controller_name = "error";
        $action_name = "index";
        $controller_class = ucwords($controller_name) . "Controller";
        $controllerInst = new $controller_class();
        $controllerInst->controller_name = $controller_name;
        $controllerInst->action_name = $action_name;
        call_user_func(array($controllerInst, $action_name), $message);
    }

    protected function _check()
    {
        $controller_name = $this->controller_name;
        $action_name = $this->action_name;
        if ($controller_name == "base" || $controller_name == "scaffold" || $controller_name == "error") {
            return "CAN'T CALL CLASS: " . ucwords($controller_name);
        }
        if ($action_name == "before" || $action_name == "after") {
            return "CAN'T CALL METHOD: " . $action_name . "()";
        }
        $controller_file = CONTROLLER_DIR . ucwords($controller_name) . "Controller.php";
        if (!file_exists($controller_file)) {
            return "CLASS FILE NOT FOUND: " . $controller_file;
        }
        $controller_class = ucwords($controller_name) . "Controller";
        if (!class_exists($controller_class)) {
            return "CLASS NOT FOUND: " . $controller_class;
        }
        $method_name = $controller_class . "::" . $action_name;
        if (!method_exists($controller_class, $action_name)) {
            return "METHOD NOT FOUND: " . $method_name . "()";
        }
        if (!is_callable($method_name)) {
            return "CAN'T CALL METHOD: " . $method_name . "()";
        }

        return true;
    }

    protected function _parseParams($controller, $action)
    {
        $res = array(
            'controller' => $controller,
            'action' => $action,
            'args' => array(),
        );
        if (empty($_GET['mode'])) {
            return $res;
        }
        $params_list = explode("/", $_GET['mode']);
        foreach ($params_list as $key => $val) {
            switch ($key) {
                case 0:
                    if (!$val) {
                        continue;
                    }
                    $res['controller'] = $val;
                    break;
                case 1:
                    if (!$val) {
                        continue;
                    }
                    $res['action'] = $val;
                    break;
                default:
                    $res['args'][] = $val;
                    break;
            }
        }

        return $res;
    }
}

<?php

class Controller
{
    public $layout;
    public $controller_name;
    public $action_name;
    public $debug_list = array();
    protected $_set_list = array('_js' => array());

    protected $Model;

    public function __construct()
    {
        $this->layout = LAYOUT_DIR . "default.tpl";
        $this->Model = new Model();
    }

    public function before()
    {
    }

    public function after()
    {
    }

    protected function set($key, $val, $to_js=false)
    {
        $this->_set_list[$key] = $val;
        if($to_js)  $this->_set_list['_js'][$key]   = $val;
        JsonApi::set($key, $val);
    }

    protected function render($view = null)
    {
        $this->beforeRender();
        if (!$view) {
            $view = $this->controller_name . DS . $this->action_name;
        }
        $view_file = VIEW_DIR . $view . ".tpl";
        if (DEBUG_MODE) {
            if (!file_exists($view_file)) {
                throw new TackphpSystemException("VIEW FILE NOT FOUND: " . $view_file);
            }
        }
        foreach ($this->_set_list as $key => $val) {
            $$key = $val;
        }
        require_once($this->layout);
    }

    protected function jsonRender($data = null)
    {
        if ($data) {
            exit(JsonApi::encode($data));
        }
        exit(JsonApi::get());
    }

    protected function beforeRender()
    {
        if (DEBUG_MODE) {
            foreach ($this->_set_list as $key => $val) {
                $this->debug_list[$key] = $val;
            }
        }
    }

    protected function redirect($url)
    {
        $url = URL_ROOT . $url;
        header("Location: " . $url);
        exit;
    }

    protected function call($code = 0)
    {
        if ($code >= 0) {
            return;
        }
        $this->error(ErrorConfig::get($code));
    }

    protected function error($message = null)
    {
        if (!$message) {
            $message = "ERROR Called.";
        }
        throw new TackphpErrorException($message);
    }

    protected function begin()
    {
        return $this->Model->beginTransaction();
    }

    protected function commit()
    {
        return $this->Model->commit();
    }

    protected function rollback()
    {
        return $this->Model->rollback();
    }
}

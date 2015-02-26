<?php

class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($message = "Hello")
    {
        $this->set("message", $message);
        $this->set("is_connect", $this->Model->is_connect);
        $this->set("test", "てすと");
        $validation_errors = $this::_exec_validation(Request::getParams("GET"));
        if (!empty($validation_errors)) {
            $this->error($validation_errors);
        }

        $this->render();
    }
}

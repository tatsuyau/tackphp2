<?php

class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($message = "Hello")
    {
        $this->set("message", $message, true);
        $this->set("is_connect", $this->Model->is_connect);
        $this->render();
    }
}

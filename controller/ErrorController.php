<?php

class ErrorController extends Controller
{
    public function index($error_message = null)
    {
        if (!$error_message) {
            $error_message = "ERROR";
        }
        $this->set("error_message", $error_message);
        $this->render();
    }
}

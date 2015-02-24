<?php
class MainController extends BaseController{
	const APP_KEY = "k3hHiYl6wRqC8NpUYVGJ9ndTZ";
	const SECRET = "WRCkBs8MHjKzYQGt99peSo6JnVbAtUgG8Lf1T2QJjeSSeUsog4";
	public function __construct(){
		parent::__construct();
	}
	public function index($message="Hello"){
		$this->set("message", $message);
		$this->set("is_connect", $this->Model->is_connect);

        //$validation_errors = $this::_exec_validation(Request::getParams("GET"));
        //if(!empty($validation_errors)) $this->error($validation_errors);
        
		$this->render();
	}
}

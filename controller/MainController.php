<?php
class MainController extends BaseController{
	public function __construct(){
		parent::__construct();
	}
	public function index($message="Hello"){
		$this->set("message", $message);
		$this->set("is_connect", $this->Model->is_connect);

        $validation_errors = $this::validation_check(Request::getParams("GET"));
        if($validation_errors) $this->error($validation_errors);

		$this->render();
	}
}

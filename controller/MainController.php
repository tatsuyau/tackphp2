<?php
class MainController extends BaseController{
	public function __construct(){
		parent::__construct();
	}
	public function index($message="Hello"){
		$this->set("message", $message);
		$this->render();
	}
}

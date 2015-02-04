<?php
class MainController extends Controller{
	public function __construct(){
		parent::__construct();
		$this->Model	= new Model();
	}
	public function index(){
		$this->render();
	}
	public function view($message="hi!"){
		$this->set("message", $message);
		$this->render("main/message");
	}
}

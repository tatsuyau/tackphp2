<?php
class ErrorController extends Controller{
	public function index($error_message){
		$this->set("error_message", $error_message);
		$this->render();
	}
}

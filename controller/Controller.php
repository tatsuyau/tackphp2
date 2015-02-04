<?php
class Controller{
	public $layout;
	public $controller_name;
	public $action_name;
	public $debug_list = array();
	protected $_set_list = array();
	public function __construct(){
		$this->layout	= LAYOUT_DIR . "default.tpl";
	}
	public function before(){
	}
	public function after(){
	}
	protected function set($key, $val){
		$this->_set_list[$key]	= $val;
	}
	protected function render($view=null){
		$this->beforeRender();
		if(!$view)	$view = $this->controller_name . DS . $this->action_name;
		$view_file = VIEW_DIR . $view . ".tpl";
		if(!file_exists($view_file))	throw new Exception("VIEW FILE NOT FOUND: " . $view_file);
		foreach($this->_set_list as $key => $val){
			$$key	= $val;
		}
		require_once($this->layout);
	}
	protected function beforeRender(){
		if(DEBUG_MODE){
			foreach($this->_set_list as $key => $val){
				$this->debug_list[$key]	= $val;
			}
		}
	}
}

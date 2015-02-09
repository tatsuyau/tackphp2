<?php
class Request{
	/*
	getParams
	getParam
	getInt
	hasPost
	getPosts
	*/
	public function getParams($method=null){
		$result	= array();
		if(!$method || $method == "GET"){
			foreach((array)$_GET as $key => $val){
				$result[$key]	= $val;
			}
		}
		if(!$method || $method == "POST"){
			foreach((array)$_POST as $key => $val){
				$result[$key]	= $val;
			}
		}
		return $result;
	}
	public function getParam($key_name, $method=null){
		$result	= null;
		$params	= $this->getParams($method);
		foreach($params as $key => $val){
			if($key != $key_name) continue;
			$result	= $val;
			break;
		}
		return $params;
	}
	public function getInt($key_name, $method=null){
		$result	= $this->getParam($key_name, $method);
		if(!$result)	return 0;
		if(!is_numeric($result))	return 0;
		return $result;
	}
	public function hasPost(){
		return (!empty($_POST)) ? true : false;
	}
}

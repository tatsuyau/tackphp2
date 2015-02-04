<?php
class Route{
	public static $list = array(
		"/"	=> "main/index",
		"/new"	=> "main/index",
	);
	public static function get($path){
		$path	= "/" . $path;
		if(empty(self::$list[$path]))	return array();
		return self::$list[$path];
	}
}

<?php
class SqlLog{
	protected static $list = array();
	public static function getList(){
		return self::$list;
	}
	public static function set($sql, $params=array()){
		self::$list[]	= array(
			'sql'	=> $sql,
			'params'=> $params,
		);
	}
}

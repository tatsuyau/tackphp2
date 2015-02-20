<?php
/*
* よく使うようなシンプルな関数はこちらへ
*/
function h($value, $key=null){
	$str	= $value;
	if(is_array($value)){
		if(empty($key) || empty($value[$key])){
			$str	= "";
		}else{
			$str	= $value[$key];
		}
	}
	echo htmlspecialchars($str);
}
function dump($var){
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

<?php
/*
* よく使うようなシンプルな関数はこちらへ
*/
function h($str){
	echo htmlspecialchars($str);
}
function dump($var){
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

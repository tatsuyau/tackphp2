<?php
class Session{
	public static function start(){
		session_start();
		session_regenerate_id(true);
	}
	public static function destroy(){
		session_destroy();
	}
}

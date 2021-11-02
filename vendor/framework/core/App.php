<?php 

namespace framework\core;

class App 
{
	public static $app = null;
	public static $request;

	function __construct(){

	}
	public static function request(){

		if (!self::$app) {
			self::$app = new App();
		}

		self::$request = $_SERVER['REQUEST_METHOD'];

		return self::$app;
	}

	public static function get($key = null, $value = null){
		
		if (self::$request == 'GET') {
			if (isset($key) && isset($_GET[$key])) {
				return $_GET[$key];
			}elseif (isset($key) && !isset($_GET[$key]) && is_null($value)) {
				return null;
			}elseif (isset($key) && !isset($_GET[$key]) && !is_null($value) ) {
				return $value;
			}elseif ( is_null($key) && is_null($value) ) {
				return $_GET;
			}
		}else{
			return false;
		}
	}
	public static function post($key = null, $value = null){
		
		if (self::$request == 'POST') {
			if (isset($key) && isset($_POST[$key])) {
				return $_POST[$key];
			}elseif (isset($key) && !isset($_POST[$key]) && is_null($value)) {
				return null;
			}elseif (isset($key) && !isset($_POST[$key]) && !is_null($value) ) {
				return $value;
			}elseif ( is_null($key) && is_null($value) ) {
				return $_POST;
			}
		}else{
			return false;
		}
	}
}
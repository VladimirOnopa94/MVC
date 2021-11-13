<?php 

namespace framework\core;

class App 
{
	public static $app = null;
	public static $request;

	function __construct(){
		self::$request = $_SERVER['REQUEST_METHOD'];
	}
	
	public static function request(){

		if (!self::$app) {
			self::$app = new App();
		}
		return self::$app;
	}
	/*
		Получить параметры GET запроса если есть
	*/ 
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
	/*
		Получить параметры POST запроса если есть
	*/ 
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
	/*
		Текущий запрос является GET запросом
	*/ 
	public static function isGet(){
		if (self::$request == 'GET') {
			return true;
		}else{
			return false;
		}
	}
	/*
		Текущий запрос является POST запросом
	*/ 
	public static function isPost(){
		if (self::$request == 'POST') {
			return true;
		}else{
			return false;
		}
	}
	/*
		Текущий запрос является AJAX запросом
	*/ 
	public static function isAjax(){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
		  return true;  
		}else{
			return false;
		}
	}
}
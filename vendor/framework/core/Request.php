<?php 
namespace framework\core;


/**
 * Класс для работы с запросами
 */
class Request 
{	
	public static $request; //тип запроса
	
	public function __construct(){
		self::$request = $_SERVER['REQUEST_METHOD'];

	}
	
	
	/**
	 * Получить параметры GET запроса если есть
	 * @return mixed 
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

	/**
	 * Получить параметры POST запроса если есть
	 * @return mixed 
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

	/**
	 * Текущий запрос является GET запросом 
	 * @return boolean 
	 */
	public static function isGet(){
		if (self::$request == 'GET') {
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Текущий запрос является POST запросом 
	 * @return boolean 
	 */
	public static function isPost(){
		if (self::$request == 'POST') {
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Текущий запрос является AJAX запросом 
	 * @return boolean 
	 */
	public static function isAjax(){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
		  return true;  
		}else{
			return false;
		}
	}

	/**
	 * Сгенерировать CSRF токен
	 * @return string
	 */
	public static function getCSRFToken (){
		if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
			$_SESSION['token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['token'];
	}
}
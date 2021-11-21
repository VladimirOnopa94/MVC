<?php 
namespace framework\core;

/**
 * Получение или генерация CSRF токена
 */
class Csrf
{
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
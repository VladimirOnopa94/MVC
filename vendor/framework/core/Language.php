<?php 

namespace framework\core;
use Exception;
/**
 *  Класс переводов
 */
class Language 
{

	public static $lang_data = [];

	/*
		Подключение файлов по имени вида
	*/
	public static function includeLang ($code = LANG['def_lang'], $view )
	{

		$lang_file = APP . '/language/' . $code . '/' . $view . '.php';
		
		if (file_exists($lang_file)) {
			self::$lang_data = require_once $lang_file;
		}

	}

	/*
		Получить фразу по ключу 
	*/
	public static function getPhrase ($key)
	{
		return isset(self::$lang_data[$key]) ? self::$lang_data[$key] : $key;
	}

	/*
		Формирование юрл с учетом языка
	*/
	public static function transformUrl ($url)
	{
		//если еще не выбран язык поставим по умолчанию
		if (!isset($_COOKIE['lang'])) {
			$_COOKIE['lang'] = LANG['def_lang'];
		}

		$url = explode('/', ltrim($url, '/'));
		$isHasLang =  array_key_exists ($url[0], LANG['langs']);
		$isDefLang =  $_COOKIE['lang'] == LANG['def_lang'];

		//для AJAX запросов 
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			array_unshift($url, $_COOKIE['lang']);
			$resultUrl = rtrim(implode('/', $url),'/');
			return $resultUrl;
		}

		/*Если в $_COOKIE['lang'] язык по умолч. и отключен показ языка по умолч. 
		и в юрл языка нет то добавим для работы роутера*/
		if (!$isHasLang && !LANG['show_default'] && $isDefLang) {
			array_unshift($url, $_COOKIE['lang']);
			$resultUrl = rtrim(implode('/', $url),'/');
			return $resultUrl;
		}

		/*Если в $_COOKIE['lang'] язык по умолч. и отключен показ языка по умолч. 
		и в юрл есть язык то вірежем его из url и перенаправим без него*/
		if ($isHasLang && !LANG['show_default'] && $isDefLang) {
			array_shift($url);
			self::redirect($url);
		}

		if(!$isHasLang && LANG['show_default']){
			array_unshift($url, $_COOKIE['lang']);
			self::redirect($url);
		}

		if (!$isDefLang && !$isHasLang) {
			array_unshift($url, $_COOKIE['lang']);
			self::redirect($url);
		}

		if ($isHasLang && ($_COOKIE['lang'] != $url[0]) ) { //  если был переключен язык
			array_shift($url);
			array_unshift($url, $_COOKIE['lang']);
			self::redirect($url);
		}
		$resultUrl = rtrim(implode('/', $url),'/');
		return $resultUrl;
		
		
	}

	/*
		Переключаем язык и редиректим на url с которого было нажатие
	*/
	public static function SetLang($code)
	{	
		if (array_key_exists($code, LANG['langs']) ) {
			setcookie('lang' , $code, time() +3600*24*7, '/');
		}

		redirectBack();die;
	}

	/*
		Если пользователь меняет язык, отловим это , 
		для того что бы в Router корректно отработал метод
	*/
	public static function isLangSwitch ($url)
	{	
		$url = explode('/', ltrim($url, '/'));
		if ($url[0] == 'language' && array_key_exists ($url[1], LANG['langs'])) {
			self::SetLang($url[1]);
		}
	}

	/*
		Преобразование в строку и редирект по указаному url
	*/
	private static function redirect($url){
		$resultUrl = rtrim(implode('/', $url),'/');
		header("Location: /" . $resultUrl);
		die;
	}

	/*
		Преобразовать ссылку url в соответствии с языком
	*/
	public static function createLink($url){

		if (isset($url)) {
			$url = explode('/', ltrim($url, '/'));
			$isHasLang =  array_key_exists ($url[0], LANG['langs']);
			if ($isHasLang) {
				array_shift($url);
				array_unshift($url, $_COOKIE['lang']);
			}else{
				array_unshift($url, $_COOKIE['lang']);
			}
			$resultLink = '/' . rtrim(implode('/', $url),'/');
			return $resultLink;
		}

	}

	/*
		Получить текущий язык
	*/
	public static function getLang(){

		if (isset($_COOKIE['lang'])) {
			return $_COOKIE['lang'];
		}else{
			return $_COOKIE['lang'] = LANG['def_lang'];
		}

	}




}
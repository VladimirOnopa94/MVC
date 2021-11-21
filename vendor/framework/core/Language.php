<?php 

namespace framework\core;
use Exception;
/**
 *  Класс переводов
 */
class Language 
{

	public static $lang_data = [];

	/**
	 * Подключение файлов по имени вида
	 * @param  string $code [description]
	 * @param  string $view 
	 */
	public static function includeLang ($code = null, $view )
	{
		$langSettings = config('kernel.language');
		if (is_null($code)) {
			$code = $langSettings['langs'];
		}		
		$lang_file = APP . '/language/' . $code . '/' . $view . '.php';
		
		if (file_exists($lang_file)) {
			self::$lang_data = require_once $lang_file;
		}

	}

	/**
	 * Получить фразу по ключу 
	 * @param  string $key 
	 */
	public static function getPhrase ($key)
	{
		return isset(self::$lang_data[$key]) ? self::$lang_data[$key] : $key;
	}


	/**
	 * Формирование юрл с учетом языка
	 * @param  string $url 
	 */
	public static function transformUrl ($url)
	{
		$langSettings = config('kernel.language');
		$def_lang = $langSettings['def_lang'];
		$langs = $langSettings['langs'];
		$show_default = $langSettings['show_default'];

		//установим язык поставим по умолчанию если не выбран 
		if (!isset($_COOKIE['lang'])) {
			$_COOKIE['lang'] = $def_lang;
		}

		$url = self::buildUrl(); 
		$url = explode('/', ltrim($url, '/'));
		
		$isHasLang =  array_key_exists ($url[0], $langs);
		$isDefLang =  $_COOKIE['lang'] == $def_lang;
		
		//для AJAX запросов 
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			array_unshift($url, $_COOKIE['lang']);
			$resultUrl = rtrim(implode('/', $url),'/');
			return $resultUrl;
		}


		/*Если в $_COOKIE['lang'] язык по умолч. и отключен показ языка по умолч. 
		и в юрл языка нет то добавим для работы роутера*/
		if (!$isHasLang && !$show_default && $isDefLang) {
			array_unshift($url, $_COOKIE['lang']);
			$resultUrl = rtrim(implode('/', $url),'/');

			return $resultUrl;
		}

		/*Если в $_COOKIE['lang'] язык по умолч. и отключен показ языка по умолч. 
		и в юрл есть язык то вырежем его из url и перенаправим без него*/
		if ($isHasLang && !$show_default && $isDefLang) {
			array_shift($url);
			self::redirect($url);
		}

		if(!$isHasLang && $show_default){
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

	/**
	 * Формирование url
	 * @return string Свормированая строка url
	 */
	private static function buildUrl(){
		$url_original = parse_url(siteUrl() . $_SERVER['REQUEST_URI']); 
		$url = $url_original; 
		
		if (isset($url['path'])) {
			$url = explode('/', $url['path']);
			$url  = array_values(array_filter($url));
		}

		if (isset($url_original['query'])) {
			if (count($url) > 0) {  
				$index = count($url) - 1; 
				$url[$index] = $url[$index] . '?' . $url_original['query'];
			}
		}
		return implode('/', $url);
		
	}

	/**
	 * Переключаем язык и редиректим на url с которого было нажатие
	 * @param  string $code 
	 */	
	private static function SetLang($code)
	{	
		$langSettings = config('kernel.language');
		if (array_key_exists($code, $langSettings['langs'] ) ) {
			setcookie('lang' , $code, time() +3600*24*7, '/');
		}
		
		//Заменяем старый язык в url на новый и редиректим
		//
		$url = str_replace(siteUrl(), '', $_SERVER['HTTP_REFERER']); 
		
		$url = ltrim($url, '/');
	
		$url_parse = parse_url($url);

		if (isset($url_parse['path'])) {
			$url = explode('/', $url_parse['path']);
		}else{
			$url = str_replace(siteUrl(), '', $_SERVER['HTTP_REFERER']); 
			$url = explode('/', $url);
		}
		
		if ($url && count($url) > 1 && array_key_exists($url[0], $langSettings['langs'])) {
			array_shift($url);
		}elseif ( $url && count($url) == 1 && array_key_exists($url[0], $langSettings['langs'])) { 
			$url = [];
		}

		$url = array_filter($url);

		array_unshift($url, $code);

		$res_url = 	implode('/', $url);
		$res_url = 	parse_url($res_url);

		if (isset($url_parse['query']) && !isset($res_url['query'])) {
			if (count($url) > 0) {
				$index = count($url) - 1;
				$url[$index] = $url[$index] . '?' . $url_parse['query'];
			}
		}

		redirect('/' . implode('/', $url));
		
		die;
	}

	/**
	 * Если пользователь меняет язык, отловим это , для того что бы в Router корректно отработал метод
	 * @param  string $url 
	 */	
	public static function isLangSwitch ($url)
	{	

		$langSettings = config('kernel.language');
		$url = explode('/', ltrim($url, '/'));

		if ($url[0] == 'language' && array_key_exists ($url[1],  $langSettings['langs'])) {
			self::SetLang($url[1]);
		}
	}

	/**
	 * Преобразование в строку и редирект по указаному url
	 * @param  string $url 
	 */
	private static function redirect($url){

		$resultUrl = rtrim(implode('/', $url),'/');
		redirect('/' . $resultUrl);
		die;
	}

	/**
	 * Преобразовать ссылку url в соответствии с языком
	 * @param  string $url 
	 */
	public static function createLink($url){

		$langSettings = config('kernel.language');

		$def_lang = $langSettings['def_lang'];
		$isDefLang =  $_COOKIE['lang'] == $def_lang;

		if (isset($url)) {
			$originalUrl = $url;
			if (($isDefLang && $langSettings['show_default'] === true) || $isDefLang === false) {

				$url = explode('/', ltrim($url, '/'));

				$isHasLang =  array_key_exists ($url[0],  $langSettings['langs']);
				if ($isHasLang) {
					array_shift($url);
					array_unshift($url, $_COOKIE['lang']);
				}else{
					array_unshift($url, $_COOKIE['lang']);					
				}
				$resultLink = rtrim(implode('/', $url),'/');
			}else{
				$resultLink = ltrim(rtrim($url,'/'), '/');
			}
			
			$resultLink = siteUrl() . '/' . str_replace('/?', '?', $resultLink);
			
			return $resultLink;
		}

	}

	/**
	 * Получить текущий язык
	 * @return string
	 */
	public static function getLang(){
		$langSettings = config('kernel.language');
		if (isset($_COOKIE['lang'])) {
			return $_COOKIE['lang'];
		}else{
			return $_COOKIE['lang'] =  $langSettings['def_lang'];
		}

	}




}
<?php 

namespace framework\core;
use Exception;
/**
 *  Класс переводов
 */
class Localization 
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
			self::$lang_data = require $lang_file;

		}

	}

	/**
	 * Получить фразу по ключу 
	 * @param  string $key 
	 * @param  array $data 
	 * @return string Сформированая строка перевода
	 */
	public static function getPhrase (string $key, array $data)
	{
		$keys = explode('.', $key);

		$phrase = self::$lang_data;
		//Проходимся по всем переданым ключам
		array_walk_recursive($keys, function($v, $k) use (&$phrase){
			if (is_array($phrase)) {
				if (array_key_exists($v, $phrase)) {
					$phrase = $phrase[$v];
				}
			}else{
				$phrase = false;
			}
		});

		if ($phrase !== false) {
			$text = $phrase;
		}else{
			return $key;
		}

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$text = str_replace(':' . $key, $value, $text);
			}
		}
		return $text;
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
			$_COOKIE['lang'] = $code; //Перезапишем принудительно что бы поменять язык для этого запроса 

		}	
		//Заменяем старый язык в url на новый и редиректим
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

		$code = self::getLang($langSettings['hide_default']); //Получаем текущую метку языка если есть, для добавления в url

		if (!empty($code)) {
			array_unshift($url, $code);
		}
		
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
	 * Преобразовать ссылку url в соответствии с передаными параметрами
	 * @param  string $url 
	 * @param  string $prefix 
	 * @param  boolean $short 
	 * @return string  
	 */
	public static function createLink($url, $prefix, $short){

		if (isset($url)) {

			$resultLink = ltrim(rtrim($url,'/'), '/');

			if (!empty($prefix)) {
				$resultLink = $prefix . '/' . $resultLink;
			}

			if ($short === true) { //формируем ссылку без домена
				$resultLink = '/' . str_replace('/?', '?', $resultLink);
			}else{
				$resultLink = siteUrl() . '/' . str_replace('/?', '?', $resultLink);
			}

			return $resultLink;
		}

	}

	/**
	 * Получить текущий язык
	 * @param  boolean $forceHideDefaultLanguage [Не отображать язык если язык по умолчанию скрыт]
	 * @return string
	 */
	public static function getLang($forceHideDefaultLanguage = false){
		$langSettings = config('kernel.language');

		if (isset($_COOKIE['lang'])) {
			
			if ($forceHideDefaultLanguage == true && ($_COOKIE['lang'] == $langSettings['def_lang'] && $langSettings['hide_default'] == true) ) {
				return '';
			}

			return $_COOKIE['lang'];
		}else{

			$_COOKIE['lang'] =  $langSettings['def_lang'];

			if ($forceHideDefaultLanguage == true && ($_COOKIE['lang'] == $langSettings['def_lang'] && $langSettings['hide_default'] == true) ) {
				return '';
			}
			return $_COOKIE['lang'];
			
		}

	}




}
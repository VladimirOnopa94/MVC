<?php 


/**
 * Получение фразы перевода по ключу
 * @param  strung $key  
 * @param  array  $data 
 * @return string      
 */
function __($key, $data = [])
{
	return \framework\core\Language::getPhrase($key, $data);
}
/**
 * Формирование ссылки 
 * @param  string  $url    
 * @param  string  $prefix префикс ссылки
 * @param  boolean $short  добавлять домен?
 * @return string          сформированая ссылка
 */
function url($url, $prefix = '', $short = false) 
{
	return \framework\core\Language::createLink($url, $prefix, $short);
}
/**
 * Формирование роута
 * @param  string $name       имя роута
 * @param  array  $attributes атрбибуты роута
 * @return string             сформированая ссылка роута
 */
function route($name, $attributes = []) 
{
	return \framework\core\Route\Route::generateRoute($name, $attributes);
}
/**
 * Получить префикс роута                     
 */
function getRoutePrefix() 
{
	return \framework\core\Route\Router::$prefix;
}
/**
 * Текущий url                        
 */
function currLoc() 
{
	return $_SERVER['REQUEST_URI'];
}
/**
 * Вернуть текущий язык
 * @param  boolean $forceHideDefaultLanguage 
 * @return string                          
 */
function getLang($forceHideDefaultLanguage = false) 
{
	return \framework\core\Language::getLang($forceHideDefaultLanguage);
}
/**
 * Вернуть текущий токен
 */
function csrfToken() 
{
	return \framework\core\App::$app->request->getCSRFToken();
}
/**
 * Редирект по url
 * @param  string $url 
 */
function redirect($url) 
{
	header('Location: ' . $url);
}
/**
 * Редирект назад
 */
function redirectBack() 
{
	redirect($_SERVER['HTTP_REFERER']);
}
/**
 * Получить url сайта без строки запроса 
 * @return string 
 */
function siteUrl() 
{
	return  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
}
/**
 * Получить полный юрл текущей страницы
 * @return string 
 */
function base() 
{
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return rtrim($url, '/');
}
/**
 * Укороченая функция дампа
 * @return mixed 
 */
function dd($var)
{ 
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	exit;
}
/**
 * Сформировать абсолютный путь к ресурсу
 * @param mixed $url ссылка на ресурс
 * @return string 
 */
function resource($url) 
{
	if (isset($url) && !empty($url)) {
		$url = ltrim($url, '/');
		return siteUrl() . '/' . $url ;
	}
	return '';
}
/**
 * Вернем код ответа
 * @param integer $code 
 */
function abort($code = 404) 
{
	http_response_code($code);
}
/**
 * Обработать теги html
 * @param  string $value 
 * @return string       
 */
function encode_var($value) 
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
/**
 * Сформировать иерархически правильный массив $_FILES 
 * @param  array $array массив файлов
 * @return array   
 */
function formateArray($array) 
{
	$result = array(); 
    foreach($array as $key1 => $value1){
        foreach($value1 as $key2 => $value2){
            $result[$key2][$key1] = $value2; 
        }
    }
    return $result; 
}
/**
 * Рандомная строка
 * @param  integer $length 
 * @return string          
 */
function randomToken($length = 10) 
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/**
 * Получить значение из файла конфига
 * @param  string $configKey имя ключа
 * @return mixed           
 */
function config($configKey) 
{
	$path  = CONFIG;
	$files = glob(CONFIG.'/*.{php}', GLOB_BRACE);
	$configResult = [];

	if (!empty($files)) {
		foreach ($files as $key => $config) {
			$info = pathinfo($config);
			$configResult[$info['filename']] = $config ;
		}
		$configKey = explode('.', $configKey);
		if (isset($configResult[$configKey[0]])) {
			$config = require $configResult[$configKey[0]];
			if (isset($config[$configKey[1]])) {
				return $config[$configKey[1]];
			}else{
				throw new Exception("Can't find key '{$configKey[1]}' in '{$configKey[0]}' config file");
			}
		}else{
			throw new Exception("Can't find '{$configKey[0]}' config file");
		}
	}else{
		throw new Exception("Can't find config files in {$path}");
	}
}
/**
 * Установить или отобразить временное сообщение
 * @param  string $name 
 * @param  string $data 
 * @return string       
 */
function flashMessage($name, $data = '') 
{
	if (isset($_SESSION[$name]) && empty($data)) {//Вернем сообщение и удалим временное сообщение из сесии
		$massage = $_SESSION[$name] ;
		unset($_SESSION[$name]);
		return $massage;
	}

	if (!empty($name) && !empty($data)) {//Запишем временное сообщение в сесию
		$massage = ($_SESSION[$name] = $data);
		return $massage ;
	}	
}

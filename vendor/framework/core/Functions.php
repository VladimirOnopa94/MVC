<?php 

/*Укороченая функция дампа*/
function dd($var){ 
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	exit;
}

//Получение фразы перевода по ключу
function __($key, $data = [])
{
	return \framework\core\Language::getPhrase($key, $data);
}

//Формирование ссылки 
function url($url, $prefix = '', $short = false) 
{
	return \framework\core\Language::createLink($url, $prefix, $short);
}

//Формирование роута
function route($name, $attributes = []) 
{
	return \framework\core\Route\Route::generateRoute($name, $attributes);
}

//Текущий url
function currLoc() 
{
	return $_SERVER['REQUEST_URI'];
}

//Вернуть текущий язык
function getLang($forceHideDefaultLanguage = false) 
{
	return \framework\core\Language::getLang($forceHideDefaultLanguage);
}

//Вернуть текущий токен
function csrfToken() 
{
	return \framework\core\Csrf::getCSRFToken();
}

//Редирект по url
function redirect($url) 
{
	header('Location: '.$url);
}

//Редирект назад
function redirectBack() 
{
	redirect($_SERVER['HTTP_REFERER']);
}

//Вернет залогиненого пользователя если он вошел в систему или false
function Auth() 
{
	return framework\core\Auth\Authenticate::checkAuth();
}

//Получить url сайта без строки запроса 
function siteUrl() 
{
	return  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
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

//Получить полный юрл текущей страницы
function base() 
{
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return rtrim($url, '/');
}

//Сформировать абсолютный путь к ресурсу
function resource($url) 
{
	if (isset($url) && !empty($url)) {
		$url = ltrim($url, '/');
		return siteUrl() . '/' . $url ;
	}
	return '';
}

//Вернем 404 ответ
function abort($code=404) 
{
	http_response_code($code);
}

//Обработать теги html
function encode_var($value) 
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

//Рандомная строка
function randomToken($length) 
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Получить значение из файла конфига
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

//Установить или отобразить временное сообщение
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

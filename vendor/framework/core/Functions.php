<?php 

/*Укороченая функция дампа*/
function dd($var){ 
	var_dump($var);exit;
}

//Получение фразы перевода по ключу
function __($key)
{
	return \framework\core\Language::getPhrase($key);
}

//Формирование ссылки с учетом языка
function url($url) 
{
	return \framework\core\Language::createLink($url);
}

//Текущий url
function currLoc() 
{
	return $_SERVER['REQUEST_URI'];
}

//Вернуть текущий язык
function getLang() 
{
	return \framework\core\Language::getLang();
}

//Вернуть текущий токен
function getCsrfToken() 
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
//Вернем 404 ответ
function abort($code=404) 
{
	http_response_code($code);
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
		$massage = ( $_SESSION[$name] = $data );
		return $massage ;
	}	
}

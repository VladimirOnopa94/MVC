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
function lLink($url) 
{
	echo \framework\core\Language::createLink($url);
}
//Вывести текущий язык
function getLang() 
{
	echo \framework\core\Language::getLang();
}
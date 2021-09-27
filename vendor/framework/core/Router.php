<?php 
namespace framework\core;
use Exception;
use framework\core\Language;
use framework\core\Csrf;

/**
 * Логика роутинга приложения
 */
class Router
{
	
	protected $router = [];
	

	function __construct()
	{
		session_start();

		CSRF::getCSRFToken();

		$this->router = require_once CONFIG . '/route.php' ;

		$this->default_route = '' ;

		$this->run();
	}

	//	
	//Извлекаем url
	//
	
	private  function getUrl (){
		$url = '';
		if ( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ) {
			$url = trim($_SERVER['QUERY_STRING']);
		}elseif ( $url == '' ) { // Метод по умолчанию указан в route.php как пустой ( '' => 'SomeController' )
			$url = $this->default_route;
		}
		
		/*Если переключен язык производится редирект , иначе ничего не происходит*/
		Language::isLangSwitch($url);  
		/*Формирование url с учетом языка*/
		$url = Language::transformUrl($url);

		return $url;

	}

	//	
	// Ищем совпадения в файле router.php с указаным в адрес. строке url
	//

	private function matchRoute ($url) {
		
		
		$getParamArray = array();

		// Обрабатываем $_GET параметры из url если они есть

		if ( strpos($url, '=') ) { 
			if (strpos($url, '?')) { 
				$getParamArray = explode('?', $url);
				$getParamArray = array_slice($get_par,1);
				$url = strtok($url, '?');
			}elseif (strpos($url, '&')) { 
				$getParamArray = explode('&', $url);
				$getParamArray = array_slice($getParamArray,1);
				$url = strtok($url, '&');
			}
			foreach ($getParamArray as $key => $value) {
				$get_part = explode('=', $value);
				$response['params'][$get_part[0]] = $get_part[1]; 
			}
		}

		$urlOriginal = $url;

		$url = explode('/', $url);

		foreach ($this->router as $pattern => $route) {

			$routePattern = explode('/', ltrim($pattern, '/'));

			// сразу сравниваем кол. параметров массивов роут строки и url адресса
			
			if ( count($routePattern) != count($url) ) { 
				continue;
			}

			$resultUrl = array();

			foreach ($routePattern as $k => $routeParam) {
				
				preg_match('/^{\w+}/', $routeParam, $matches);

				if ( !empty($routeParam) && empty($matches) && strpos($routeParam, $url[$k]) === false ) {	
					break;	
				}
				
				if ( !empty($routeParam) && !empty($matches)  ) {
					
					// заменяем параметр {N} параметром из url
					
					$resultUrl[] = preg_replace('/^{\w+}/', $url[$k], $routeParam);

					$routeParamReplace = str_replace('{', '', $routeParam);	

					$routeParamReplace = str_replace('}', '', $routeParamReplace);

					
					/* Если есть $_GET параметр news ( пример /category/news )

					или параметр about ( пример /page/about ) и т.п. */
					if ($routeParamReplace != 'lang') {
						$response['params'][$routeParamReplace] = $url[$k];
					}

					foreach ($url as $key => $value) {
						$isLang =  array_key_exists ($value, LANG['langs']);
						if (!$isLang) {/*Игнорируем параметр языка в массиве*/
							if (isset($_POST) && $_POST) { //Пишем POST параметры в response
								foreach ($_POST as $k_post => $v_post) {
									$response['params'][$k_post] = $v_post; 
								}
							}
							//$response['params'][$value] = $value; // ?????
						}
					}

				}// Если найден статический параметр

				elseif( !empty($routeParam) && $routeParam == $url[$k] ) {
					
					$resultUrl[] = $routeParam;

				}	
				
			}


			
			$resultUrl = rtrim(implode('/', $resultUrl),'/');


			if ( $resultUrl == $urlOriginal ) {

				$response['controller'] = $route;

				return $response;

			} elseif ( $urlOriginal == $this->default_route ) {

				$response['controller'] = $route;

				return $response;

			} else {

				continue;

			}
			
		}
	
	}

	
	/*Извлекаем из строки route контроллер и метод.

	Переменная $request всегда доступна в методе контроллера 
	и содерижит свойства params (переданые параметры в url) и 
	controller (вызываемый контроллер и метод ) */
	

	private function callControllerMethod ($request) {

		
		if($request){
			
			$str = explode('@', $request['controller']);


			$controller = 'app\controllers\\'.$str[0];

			$method = $str[1];
			
			if (isset($request['params'])) { // Преобразовываем в объект , для доступа в контроллерах сайта 
				$request = (object) $request['params'];
			}

			if (class_exists($controller)) {

				$controllerObj = new $controller;

				if ( method_exists($controllerObj, $method)) {
					
					$controllerObj->$method($request);

				} else {

					throw new Exception("Method {$method} not exsist in {$controller}");

				}

			} else {

				throw new Exception("Class {$controller} not exsist");

			}

		} else {

			throw new Exception('Not found variable $routeStr');

		}


	}

	//
	//Запуск роутинга
	//

	public function run (){

		if ( $url =  $this->getUrl() ) {
 			if ($response = $this->matchRoute($url)) {

 				$this->callControllerMethod ($response);
 			} else {
 				http_response_code(404);
 				include APP . '/views/404.php';
 			}
	
		}
	}




}
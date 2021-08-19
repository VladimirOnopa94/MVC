<?php 
namespace framework\core;
use Exception;
use framework\core\Language;

/**
 * Логика роутинга приложения
 */
class Router
{
	
	protected $router = [];

	function __construct()
	{
		$this->router = require_once CONFIG . '/route.php' ;

		$this->default_route = '' ;

		$this->run() ;

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


					// Обрабатываем $_GET параметры из url

					$get_params = explode('&', $url[$k]);

					foreach ($get_params as $key => $value) {

						if ( strpos($value, '=') ) { // Если есть $_GET параметр ( пример var=1 )
							
							$str = explode('=', $value);

							$response['params'][$str[0]] = $str[1]; 
						} else {

							/* Если есть $_GET параметр news ( пример /category/news )

							или параметр about ( пример /page/about ) и т.п. */

							$response['params'][$routeParamReplace] = $value;
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
 				include APP . '/views/404.html';
 			}
	
		}
	}


}
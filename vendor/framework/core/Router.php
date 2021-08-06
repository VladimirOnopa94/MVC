<?php 
namespace framework\core;

/**
 * Логика роутинга приложения
 */
class Router
{
	
	protected $router = [];

	function __construct()
	{
		$this->router = require_once CONFIG.'/router.php' ;

		$this->default_route = 'default' ;

		$this->run() ;

	}

	//	
	//Извлекаем url
	//
	

	private  function getUrl (){

		if ( isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ) {

			return trim($_SERVER['QUERY_STRING']);

		} elseif ( $_SERVER['QUERY_STRING'] == '' ) { // Метод по умолчанию указан в router.php как пустой ( '' => 'SomeController' )

			return $this->default_route;

		}

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

				// Если найден параметр {N}

				if ( !empty($routeParam) && !empty($matches) ) {
					
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

				return false;

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

					die("Method {$method} not exsist in {$controller} ");

				}

			} else {

				die("Class {$controller} not exsist");

			}

		} else {

			die('Not found variable $routeStr');

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

 				echo '404 page';

 			}
	
		}
	}


}
<?php 
namespace framework\core;
use Exception;
use framework\core\Language;
use framework\core\ErrorHandler;
/**
 * Логика роутинга приложения
 */
class Router
{
	protected $router = [];
	
	function __construct()
	{
		session_start();

		new ErrorHandler();	// Устанавливаем обработчик ошибок

		$this->includeRoutesFiles(); // Подключаем все файлы роутинга

		$this->default_route = '' ;

		$this->run();
	}


	/*
		Подключаем все файлы роутинга из папки routes
	*/
	private function includeRoutesFiles(){
		$path  = ROOT . '/routes';
		$files = scandir($path);
		$files = array_diff(scandir($path), array('.', '..'));
		$routeResult = [];

		if (!empty($files)) {
			foreach ($files as $key => $route) {
				$routeResult[] = require_once $path . '/' . $route ;
			}
			$this->router = array_reduce($routeResult, 'array_merge', array());
		}else{
			throw new Exception("Can't find route files in {$path}");
		}
	}

	//	
	//Извлекаем url
	//
	
	private  function getUrl (){

		$url = '';
		if ( isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '' ) {
			$url = trim($_SERVER['REQUEST_URI']);
		}elseif ( $url == '' ) { // Метод по умолчанию указан в route.php как пустой ( '' => 'SomeController' )
			$url = $this->default_route;
		}
		
		/*Если переключен язык производится редирект , иначе ничего не происходит*/
		Language::isLangSwitch($url);  
		
		
		if ($this->isServiceUrl($url) === false) {
			/*Формирование url с учетом языка*/
			$url = Language::transformUrl($url);
		}

		return $url;
	}

	/*
		Проверяем являеться ли url сервисным
	*/
	private  function isServiceUrl($url){
		if (!empty($url)) {
			$servicePrefix = config_get('kernel.service_prefix');
			$parts = explode('/', ltrim($url , '/'));
			if (in_array($parts[0], $servicePrefix)) {
				return true;
			}
		}
		return false;
	}

	/*
		Ищем совпадения в файле router.php с указаным в адрес. строке url
	*/
	private function matchRoute ($url) {

		$langSettings = config_get('kernel.language');

		// Обрабатываем $_GET параметры из url если они есть

		$fullUrl = parse_url(siteUrl() . $_SERVER['REQUEST_URI']);

		if (  isset($fullUrl['query']) ) { 
			$getParamArray = array();

			if (strpos($fullUrl['query'], '?')) { 
				$getParamArray = explode('?', $fullUrl['query']);
				$url = strtok($url, '?');
			}elseif (strpos($fullUrl['query'], '&')) { 
				$getParamArray = explode('&', $fullUrl['query']);
				$url = strtok($url, '&');
			}
			foreach ($getParamArray as $key => $value) {
				$get_part = explode('=', $value);
				$response['params'][$get_part[0]] = $get_part[1]; 
			}
		}

		$urlOriginal = ltrim($url, '/');

		$url = explode('/', ltrim($url, '/'));

		foreach ($this->router as $pattern => $route) {

			$routePattern = explode('/', ltrim($pattern, '/'));

			// сразу сравниваем кол. параметров массивов роут строки и url адресса
			
			if ( count($routePattern) != count($url) ) { 
				continue;
			}
			
			$resultUrl = array();
			
			foreach ($routePattern as $k => $routeParam) {
				
				preg_match('/^{\w+}/', $routeParam, $matches);
				if ( !empty($url[$k]) && !empty($routeParam) && empty($matches) && strpos($routeParam, $url[$k]) === false ) {	
					break;	
				}
				
				if ( !empty($routeParam) && !empty($matches)  ) {

					//фикс для url главной стр. типа (/ru  и т.д.)
					if (!array_key_exists($url[$k], $langSettings['langs'])) {
						continue;
					}
					
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
						$isLang =  array_key_exists ($value, $langSettings['langs']);
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

					//Middlewares 
					foreach ($controllerObj->getMiddlewares() as  $middleware) { 
						// Если в Middleware передан параметр метода
						if (!empty($middleware->actions)) { 
							foreach ($middleware->actions as $key => $action) {
								// Если переданный параметр совпадает с вызывающим
								if ($action == $method) { 
									$middleware->execute();
								}
							}
						}else{ 
							//Или применяем на весь контроллер который установил Middleware
							$middleware->execute();
						}
	 				}//Middlewares END

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
 				abort(404) ;
 				$controller = new Error\ErrorController();
 				$controller->ShowError();
 			}
	
		}
	}




}
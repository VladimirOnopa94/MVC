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


	/**
	 * Подключаем все файлы роутинга из папки routes
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


	/**
	 * Извлекаем url
	 * @return string
	 */
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


	/**
	 * Проверяем являеться ли url сервисным
	 * @param  string  $url 
	 * @return boolean     
	 */
	private  function isServiceUrl($url){
		if (!empty($url)) {
			$servicePrefix = config('kernel.service_prefix');
			$parts = explode('/', ltrim($url , '/'));
			if (in_array($parts[0], $servicePrefix)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Ищем совпадения в файле router.php с указаным в адрес. строке url
	 * @param  string $url 
	 * @return array
	 */
	private function matchRoute ($url) {

		$langSettings = config('kernel.language');

		// Обрабатываем $_GET параметры из url если они есть
		$parts = parse_url(base());

		if (isset($parts['query'])) { 
			parse_str($parts['query'], $query);
			foreach ($query as $key => $value) {
				$response['params'][$key] = $value; 
			}
		}

		$urlOriginal = ltrim($url, '/');

		$url = parse_url($url);
		$url = explode('/', ltrim($url['path'], '/'));

		foreach ($this->router as $pattern => $route) {

			$routePattern = explode('/', ltrim($pattern, '/'));

			// сравниваем кол. параметров массивов роут строки и url адресса
			
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
						if (!array_key_exists ($value, $langSettings['langs'])) {/*Игнорируем параметр языка в массиве*/
							if (isset($_POST) && $_POST != '') { //Пишем POST параметры в response
								foreach ($_POST as $k_post => $v_post) {
									$response['params'][$k_post] = $v_post; 
								}
							}
						}
					}

				}// Если найден статический параметр

				elseif( !empty($routeParam) && $routeParam == $url[$k] ) {
					$resultUrl[] = $routeParam;
				}	
				
			}


			$resultUrl = rtrim(implode('/', $resultUrl),'/');

			$urlOriginal = parse_url($urlOriginal);
			$urlOriginal = $urlOriginal['path'];

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

	

	/**
	 * Извлекаем из строки route контроллер и метод.
	 * Переменная $request содерижит свойства params (переданые параметры в url) и 
	 * controller (вызываемый контроллер и метод)
	 * @param  object $request 
	 */
	private function callControllerMethod ($request) {

		if($request){
			
			$str = explode('@', $request['controller']);

			$controller = 'app\controllers\\'.$str[0];

			$method = $str[1];
			
			if (isset($request['params'])) { // Преобразовываем в объект , для доступа в контроллерах сайта 
				$request = (object) $request['params'];
			}
			// Перезапишем массив $_FILES с удобной иерархией елементов
			if (isset($_FILES['file']['name'][0]) && !empty($_FILES['file']['name'][0])) {
				$_FILES = formateArray($_FILES['file']); 
			}else{
				$_FILES = [];
			}

			if (class_exists($controller)) {

				$controllerObj = new $controller;

				if ( method_exists($controllerObj, $method)) {

					//Middlewares 
					$middlewaresList = $controllerObj->getMiddlewares();
					$middlewareResponse = true;

					if (isset($middlewaresList) && !empty($middlewaresList)) {

						foreach ($middlewaresList as  $middleware) { 
							// Если в Middleware передан параметр метода
							
							if (!empty($middleware->actions)) { 
								foreach ($middleware->actions as $key => $action) {
									// Если переданный параметр совпадает с вызывающим
									if ($action == $method) { 
										$middlewareResponse = $middleware->execute();
									}
								}
							}else{ 
								//Или применяем на весь контроллер который установил Middleware
								$middlewareResponse = $middleware->execute();
							}
							//Остановим если один из middleware вернул false
							if ($middlewareResponse === false) {
								break;
							}
		 				}
	 				}
	 				//Middlewares END

	 				if ($middlewareResponse === true ) {
	 					$controllerObj->$method($request);
	 				}

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

	/**
	 * Запуск роутинга
	 */
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
<?php 
namespace framework\core\Route;
use Exception;
use framework\core\App;

class Route
{
	public $router = []; /*Массив маршрутов*/
	public $prefix; /*Префикс группы маршрутов*/
	public $suffix; /*Суфикс группы маршрутов*/
	protected static $instance;
	/**
	 * Singleton
	 * @return object 
	 */
	public static function instance() 
	{
		if (self::$instance === null) {
			self::$instance = new self ;
		}
		return self::$instance;
	}
	/**
	 * Обработка групы маршрутов
	 * @param  array $args  аргументы групы [prefix маршутов]
	 * @param  array $routes маршруты
	 */
	public function group($args = [], $routes){

		$this->prefix = (isset($args['prefix']) && !empty($args['prefix'])) ? $args['prefix'] : '';//Префикс в маршуртах если есть
		$this->suffix = (isset($args['suffix']) && !empty($args['suffix'])) ? $args['suffix'] : ''; 
		
		call_user_func($routes);

		return $this;
	}
	/**
	 * Добавление маршрута для POST метода
	 * @param  string $route  [description]
	 * @param  string $action [description]
	 * @return object      
	 */
	public function post($route, $action){

		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

		$element =  array(
			'method' => 'POST',
			'pattern' => $route,
			'action' => $action,
		);
		if (isset($backtrace[3]) && $backtrace[3]['function'] == 'group') {
			$element['prefix'] = $this->prefix;
			$element['suffix'] = $this->suffix;
		}

		$this->router[] = $element; 
		
		return $this;
	}
	/**
	 * Добавление маршрута для GET метода
	 * @param  string $route  [description]
	 * @param  string $action [description]
	 * @return object      
	 */
	public function get($route, $action){
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

		$element =  array(
			'method' => 'GET',
			'pattern' => $route,
			'action' => $action,
		);
		if (isset($backtrace[3]) && $backtrace[3]['function'] == 'group') {
			$element['prefix'] = $this->prefix;
			$element['suffix'] = $this->suffix;
		}
		
		$this->router[] = $element; 
		
		return $this;
	}
	/**
	 * Добавление имени роуту
	 * @param  string $name 
	 * @return object   
	 */
	public function name($name){

		$count = count($this->router);

		$this->router[$count-1]['name'] = $name;

		return $this;
	}
	/**
	 * Генерация роута
	 * @param  string $name 
	 * @return string       
	 */
	public static function generateRoute($name, $attributes){

		$routes = \framework\core\Route\Router::$router;

		$route = array_search($name, array_column($routes, 'name'));
		$route = $routes[$route];
		
		if (isset($route) && !empty($route)) {	
			if (isset($attributes) && !empty($attributes)) {
				$routePattern = explode('/', ltrim($route['pattern'], '/'));

				foreach ($attributes as $k => $attribute) {
					$route['pattern'] = str_replace('{'. $k .'}', $attributes[$k], $route['pattern']);
				}
			}

			$routeResult = siteUrl() . '/' . ltrim($route['pattern'], '/');
		}else{
			throw new Exception("Can't find route {$name}");
		}

		return $routeResult;

		
	}

	/**
	 * Формирования массива маршрутов
	 * @return array
	 */
	
	private function buildRoute () {
		$routeResult = array();
		
		foreach ($this->router as $key => $route) {
			$originalPrefix = (isset($route['prefix']) && !empty($route['prefix'])) ? $route['prefix'] : '';
			$originalSuffix = (isset($route['suffix']) && !empty($route['suffix'])) ? $route['suffix'] : '';

			$patternEmpty = array_filter(explode('/', $route['pattern']));

			if (isset($route['prefix']) && !empty($route['prefix']) && (count($patternEmpty) > 1)) {
				$route['prefix'] = $route['prefix'] . '/';
			}elseif (isset($route['prefix']) && !empty($route['prefix']) && (count($patternEmpty) <= 1)) {
				$route['prefix'] = $route['prefix'];
			}else{
				$route['prefix'] = '';
			}

			$route['suffix'] = (isset($route['suffix']) && !empty($route['pattern'])) ? $route['suffix'] : '';

			$pattern = $route['prefix'] . $route['pattern'] . $route['suffix'];
			$pattern = str_replace('//', '/', $pattern);

			$route['name'] = (isset($route['name'])) ? $route['name'] : $route['pattern'];

			$routeResult[] = array(
				'name' => $route['name'],
				'pattern' => $pattern,
				'method' => $route['method'],
				'action' => $route['action'],
				'suffix' => $originalSuffix,
				'prefix' => $originalPrefix,
			);
		}

		return $this->router = $routeResult;
	}

	/**
	 * Подключаем все файлы роутинга из папки routes
	 */
	public function includeRoutesFiles(){
		$path  = ROOT . '/routes';
		$files = scandir($path);
		$files = array_diff(scandir($path), array('.', '..'));
		$routeResult = [];

		if (!empty($files)) {
			foreach ($files as $key => $route) {
				$routeResult[] = require_once $path . '/' . $route ;
			}
			//$this->router = array_reduce($this->router, 'array_merge', array());
			//
			return $this->buildRoute();

		}else{
			throw new Exception("Can't find route files in {$path}");
		}
	}
	
}
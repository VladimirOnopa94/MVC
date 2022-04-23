<?php 

namespace framework\core;
use framework\core\localization;
use framework\core\App;
use Exception;

/**
 * 
 */
class Widget 
{
	public $csrf ;
	public static $param ;
	
	function __construct()
	{
		App::$app->request->getCSRFToken(); // Пишем в сессию CSRFToken

		(!isset($this->csrf)) ? $this->csrf = true : $this->csrf;

		$this->checkCSRF();
		
	}


	/**
	 * Подключаем файл вида и передаем переменные 
	 */
	public static function widget ()
	{
		//Получаем переменные переданые методу из view виджета
		$variables = func_get_args();

		$class = get_called_class();
		$obj = new $class;
		//Вызываем функцию вызваного виджета и передаем переменные
		$result = call_user_func_array(array($obj, "run"), $variables);

		if (isset($result)) { //Извлекаем переменные из контроллера для view
			
			extract($result);
		}

		try{
		   	/*Если не установлен путь к виду*/
			if (isset($result['view'])){
				$view = ltrim($result['view'],'/');
		
				$file_view = APP . "/components/widgets/views/" . $view . ".php";
			}else{
		    	throw new Exception("View path not set");
		    }


		    try{
		   		/*Если нет такого вида по заданому пути*/
				if (is_file($file_view)){
					require_once $file_view;
				}else{
			    	throw new Exception("View " . $file_view . " not found !");
			    }
			} 
			catch (Exception $ex) {
			    echo $ex->getMessage();
			}

		} 
		catch (Exception $ex) {
		    echo $ex->getMessage();
		}
	}

	/**
	 * Подключение языкового файла
	 * @param  string $view 
	 */
	public function language($view)
	{
		localization::includeLang($_COOKIE['lang'], $view);
	}

	/**
	 * Проверка наличия и валидности переданого CSRF токена 
	 */
	private function checkCSRF ()
	{
		if ($this->csrf) { 
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!isset($_POST['token'])) {
					die("CSRF not passed");
				}
				if (!hash_equals($_SESSION['token'], $_POST['token'])) {
					die("CSRF is invalid");
				}
			}
		}
		
	}


}
<?php 

namespace framework\core;

use Exception;
use framework\core\Logger;

/**
 * 
 */
class ErrorHandler 
{
		public $logger ; 

		public function  __construct(){
			if (DEBUG['enable']) {
				error_reporting(-1);
			}else{
				error_reporting(0);
			}
			$this->logger = new Logger();
			set_error_handler([$this , 'errorHandler']);
			ob_start();
			register_shutdown_function([$this , 'fatalErrorHandler']);
			set_exception_handler([$this , 'exeptionHandler']);
		}

		/*
		Обработчик ошибок
		*/
		public function errorHandler($errno, $errstr, $errfile, $errline){
			$this->logger->log(array(base(), $errfile, $errline, $errstr)  , 'error');

			$this->displayError($errno, $errstr, $errfile, $errline);
			return true;
		}

		/*
		Обработчик исключений
		*/
		public function exeptionHandler($e){
			$this->logger->log(array(base(), $e->getFile(), $e->getLine(), $e->getMessage())  , 'error');
			$this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine());
		}
		/*
		Обработчик фатальных ошибок
		*/
		public function fatalErrorHandler(){
			$error = error_get_last();

			if (!empty($error) && ($error['type'] === E_ERROR || $error['type'] === E_PARSE || $error['type'] === E_COMPILE_ERROR || $error['type'] === E_CORE_ERROR ) ) {
				$this->logger->log(array(base(), $error['file'], $error['line'], $error['type'], $error['message'])  , 'error');
				ob_end_clean();
				$this->displayError($error['type'], $error['message'], $error['file'], $error['line'] );
			}else{
				flush ();
			}

		}
		/*
		Отображение страницы ошибок 
		*/
		protected function displayError($errno, $errstr, $errfile, $errline, $response = 500){
			http_response_code($response);
			
			if ($response == 404) {
 				$controller = new Error\ErrorController();
 				$controller->ShowError();
			}
			
			if (DEBUG['enable'] && (!empty(DEBUG['ip']) && in_array($_SERVER['REMOTE_ADDR'], DEBUG['ip']))) {
				echo $errno . ' ' . $errfile . ':' . $errline . ' ' . $errstr;
			}elseif (DEBUG['enable'] && (empty(DEBUG['ip']) && !in_array($_SERVER['REMOTE_ADDR'], DEBUG['ip']))) {
				echo $errno . ' ' . $errfile . ':' . $errline . ' ' . $errstr;
			}else{
				$controller = new Error\ErrorController();
 				$controller->ShowError();
			}
			die;

		}
}
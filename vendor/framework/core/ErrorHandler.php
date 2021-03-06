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
			if (DEBUG) {
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
			
			$this->logger->log(array($errfile, $errline, $errstr)  , 'error');

			$this->displayError($errno, $errstr, $errfile, $errline);
			return true;
		}

		/*
		Обработчик исключений
		*/
		public function exeptionHandler($e){
			$this->logger->log(array($e->getFile(), $e->getLine(), $e->getMessage())  , 'error');
			$this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine());
		}
		/*
		Обработчик фатальных ошибок
		*/
		public function fatalErrorHandler(){
			$error = error_get_last();

			if (!empty($error) && $error['type'] & [E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR]) {
				$this->logger->log(array( $error['file'], $error['line'], $error['type'], $error['message'])  , 'error');
				ob_end_clean();
				$this->displayError($error['type'], $error['message'], $error['file'], $error['line'] );
			}else{
				ob_end_flush();
			}

		}
		/*
		Отображение страницы ошибок 
		*/
		protected function displayError($errno, $errstr, $errfile, $errline, $response = 500){
			http_response_code($response);
			
			if ($response == 404) {
				require APP . '/views/404.html';
				die;
			}
			if (DEBUG) {
				echo $errfile . ':' . $errline . ' ' . $errstr;
			}else{
				require APP . '/views/404.html';
			}
			die;

		}
}
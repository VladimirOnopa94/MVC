<?php 

namespace framework\core;
use Exception;

/**
 * Класс логирования
 */
class Logger 
{

	/**
	 * Запись логов в указаный файл 
	 * @param  string|array $massage 
	 * @param  string $file    
	 */
	public static function log ($massage , string $file)
	{
		try{
			$log_param = config('kernel.log_param');
			
			if (array_key_exists($file , $log_param['logs'])) {
				
				$file =  $log_param['logs'][$file] ;
				
				if (file_exists($file)) {
					/*Очищаем файл если он превысил размер */
					if (filesize($file) > $log_param['max_log_size']) { 
						file_put_contents($file, "");
					}

				}else{

					$dir = explode('/', $file);
					array_pop($dir);
					$dir = implode('/', $dir);

					try{
						if (!file_exists($dir)) {
							if (!mkdir($dir, 0777, true)){
									throw new Exception("Impossible to create dir " . $dir );
								}
							} 
						} 
					catch (Exception $ex) {
					    echo $ex->getMessage();
					}
				}

				$d_t = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
				$f_elem = array_shift($d_t);
				if (is_array($massage)) {
					$massage = '[' . date('Y-m-d H:i:s') . '] '. json_encode($massage);
				}else {
					$massage = '[' . date('Y-m-d H:i:s') . '] '. $f_elem['file'] . ':' . $f_elem['line']  . ' message : ' . $massage;
				}
				error_log($massage . PHP_EOL, 3, $file);
			}else{
				throw new Exception("Undefined index: " . $file . ' in config "LOG_PARAM[`logs`]"'  );
			}
		}
		catch (Exception $ex) {
		    echo $ex->getMessage();
		}	

	}


}
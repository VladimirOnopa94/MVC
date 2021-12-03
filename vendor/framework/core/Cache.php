<?php 
 namespace framework\core; 
/**
 * Класс кеширования
 */
class Cache 
{
	
	function __construct()
	{
		
	}
	/**
	 * Запись в файл кеша
	 * @param string  $key имя файла кеша
	 * @param mixed  $data    данные для записи
	 * @param integer $duration длительность в сек.
	 */
	public function set($key, $data, $duration = 3600){
		$duration =  time() + $duration;
		if ( isset($data) && isset($key) && file_put_contents(CACHE . '/' . $key . '.' . $duration , serialize($data))) {
			return true;
		}
		return false;
	}
	/**
	 * Получение файла кеша
	 * @param  string $key имя файла кеша
	 * @return  данные из файла
	 */
	public function get($key){
		$file = glob( CACHE . '/' . $key . '.*');

		if (isset($key) && $file) {
			$parts = explode($key . '.', $file[0]);
			
			if ( time() <= $parts[1]) {
				return unserialize(file_get_contents($file[0]));
			}
			unlink($file[0]);
		}
		return false;
	}
}
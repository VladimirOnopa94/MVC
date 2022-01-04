<?php 
namespace framework\core;

/**
 * Класс для работы с файлами
 */
class File 
{

	/**
	 * Загрузка файла 
	 * @param  array $file массив файла
	 * @param  string $path путь к каталогу загрузки
	 * @param  string $name имя файла 
	 * @return bool       результат загрузки
	 */
	public static function move($file, $path, $name = ''){

		if (isset($file) && !empty($file)) {

			if (!file_exists($path)) {
			    mkdir($path, 0775, true);
			}

			$tmp_name = $file['tmp_name'];

			if (empty($name)) {
				$name = $file['name'];
			}
			$name = ltrim($name, '/');

			$path = rtrim($path, '/') . '/' . $name;

			if(move_uploaded_file($tmp_name, $path))
			{
			  return true;
			}
			
		}
		return false;
	}

}
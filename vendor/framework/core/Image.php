<?php 
namespace framework\core;

/**
 * Класс для работы с изображением
 */
class Image 
{

	private static $type = '';
	private static $originalFile;
	private static $quality = 100;
	private static $width = '';
	private static $height = '';

	/**
	 * Инициализация переменных
	 * @param  array $file 
	 * @return object    
	 */
	public static function create($file){

		if (isset($file['name'])) {
			self::$originalFile = $file;
		}
		return new static;
	}
	/**
	 * Установка формата и качества изображения
	 * @param  string  $type    
	 * @param  integer $quality 
	 * @return object
	 */
	public static function encode($type, $quality){
		if (isset($type)) {
			self::$type = $type;
		}
		self::$quality = $quality;
		
		return new static;
	}
	/**
	 * Установка размера изображения
	 * @param  integer $width  
	 * @param  integer $height 
	 * @return object
	 */
	public static function size(int $width,  int $height ){
		self::$width = $width;
		self::$height = $height;

		return new static;
	}
	/**
	 * Процесс сохранения изображения
	 * @param  string $path 
	 * @param  string $name 
	 */
	public static function save($path, $name = ''){

		list($width, $height, $type) = getimagesize(self::$originalFile['tmp_name']);
		
		$path = rtrim($path, '/') . '/';

		/*Если не указано новое имя файла, ставим исходное*/
		if (empty($name) || is_null($name) || !$name) {
			$name = pathinfo(self::$originalFile['name']);
			$name = $name['filename'];
		}

		/*Если не указан расширение файла, ставим исходное*/
		if (!self::$type) {
			self::$type = pathinfo(self::$originalFile['name'], PATHINFO_EXTENSION);
		}

		/*Если не указаны размеры, сиавим исходные*/
		if (empty(self::$width) || empty(self::$height)) {
			self::$width = $width;
			self::$height = $height;
		}

		$old_image = self::load_image($type);
		
		$image = self::resize_image_to_width_height(self::$width, self::$height, $old_image, $width, $height);

		self::save_image($image, $path, $name, self::$type, self::$quality);
	}
	/**
	 * Ресайз изображения по ширине и высоте
	 * @param  integer $new_width  
	 * @param  integer $new_height 
	 * @param  $image      
	 * @param  integer $width     
	 * @param  integer $height    
	 */
	private static function resize_image_to_width_height($new_width, $new_height, $image, $width, $height) {

		$resize_ratio = $new_width / $width;
		$new_height = $height * $resize_ratio;

		$ratio = $new_height / $height;
		$new_width = $width * $ratio;

		return self::resize_image($new_width, $new_height, $image, $width, $height);
	}
	/**
	 * Ресайз изображения
	 * @param  integer $new_width  
	 * @param  integer $new_height 
	 * @param  $image      
	 * @param  integer $width     
	 * @param  integer $height    
	 */
	private static function resize_image($new_width, $new_height, $image, $width, $height){
		$new_image = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		return $new_image;
	}
	/**
	 * Создание изображения
	 * @param  integer $type 
	 */
	private static function load_image($type){
		$filename = self::$originalFile['tmp_name'];

		if ($type == IMAGETYPE_JPEG) {
			$image = imagecreatefromjpeg($filename);
		}elseif ($type == IMAGETYPE_PNG){
			$image = imagecreatefrompng($filename);
		}elseif ($type == IMAGETYPE_GIF){
			$image = imagecreatefromgif($filename);
		}elseif ($type == IMAGETYPE_WEBP){
			$image = imagecreatefromwebp($filename);
		}

		return $image;
	}
	/**
	 * Создание изображения
	 * @param  $new_image    
	 * @param  string $new_filename 
	 * @param  string $new_type     
	 * @param  integer $quality     
	 */
	private static function save_image($new_image, $path, $new_filename, $new_type='jpeg', $quality) {

		$new_filename = $path . $new_filename . '.' . $new_type;

		if ($new_type == 'jpeg' || $new_type == 'jpg' ){
			imagejpeg($new_image, $new_filename, $quality);
		}elseif ($new_type == 'png'){
			($quality == 100) ? $quality = 0 : $quality = intval((100 - $quality) / 10);

			imagepng($new_image, $new_filename, $quality);
		}
		elseif ($new_type == 'gif'){
			imagegif($new_image, $new_filename);
		}
		elseif ($new_type == 'webp'){
			imagewebp($new_image, $new_filename, $quality);
		}
	}




	
}
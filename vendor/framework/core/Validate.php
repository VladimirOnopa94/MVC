<?php 

namespace framework\core;
use Exception;

/**
 * Валидация данных
 */
class Validate 
{

	/**
	 * Загружаем данные
	 * @var Array
	 */
	private static $data; 
	/**
	 * Массив ошибок
	 * @var Array
	 */
	private static $errors; 
	/**
	 * Массив типов
	 * @var Array
	 */
	private static $allowedImageExtension = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'];
	/**
	 * Массив регулярных выражений
	 * @var Array
	 */
	private static $regexes = array(
        'date'        => "#^[0-9]{1,2}[-/][0-9]{1,2}[-/][0-9]{4}$#",
        'alpha'       => '#^[A-Za-z]+[A-Za-z \\s]*$#',
        'alphanumeriс'     => "#^[a-zA-Z0-9_]*$#",
    );

    	
   /**
    * Загружаем данные в переменную data
    * @param  Array $array 
    * @return Object       
    */
	public static function load ($array){		
		if (!empty($array)) {
			self::$data = $array;
		}
		return new static;
	}

	/**
	 * Валидируем данные в соответсвии с передаными полями и правилами
	 * @param  Array $rules 
	 * @return Array or null      
	 */
	public static function validate ($rules){
		if (is_null(self::$data)) {
			throw new Exception('Data for validation is not set, use VD::load($data) ');
		}
		if (!empty($rules)) {
			foreach ($rules as $key_rule => $rule) {
				$rule = explode('|', $rule);
				foreach ($rule as $key_item => $rule_item) {

					$tmp = $rule = explode(':', $rule_item);
					$ruleName = $tmp[0];

					if (!method_exists (get_called_class(), $ruleName)) {
						return ['method not exsist'];
					}

					if (count($tmp) > 1) {
						$ruleArg = $tmp[1];
						call_user_func_array(array(__NAMESPACE__ .'\Validate', $ruleName), array($key_rule, $ruleArg));
					}else{
						call_user_func(array(__NAMESPACE__ .'\Validate', $ruleName), $key_rule);
					}
				}
			}
		}else{
			return 'Set rules';
		}

		if (empty(self::$errors)) {
			return null;
		}else{
			foreach (self::$errors as $key => $value) {
				$error[$key] = implode('<br>', $value);
			}
			return $error;
		}
	}

	/**
	 * Валидация максимального кол. символов
	 * @param  String $field 
	 * @param  String $args  
	 * @return errors       
	 */
	private static function max ($field, $args){
		$length = strlen(self::$data[$field]);

		if ($length > $args ) {
			self::$errors[$field][] = "Поле {$field} должно иметь меньше {$args} символов";
		}
	}
	/**
	 * Валидация минимального кол. символов
	 * @param  String $field 
	 * @param  String $args  
	 * @return errors       
	 */
	private static function min ($field, $args){
		$length = strlen(self::$data[$field]);

		if ($length < $args ) {
			self::$errors[$field][] = "Поле {$field} должно иметь больше {$args} символов";
		}
	}
	/**
	 * Валидация наличия заполненого поля
	 * @param  String $field 
	 * @return errors      
	 */
	private static function required ($field){
		$data = self::$data[$field];

		if (!isset($data) || empty($data) ) {
			self::$errors[$field][] = "Поле {$field} обязательное";
		}
	}
	/**
	 * Валидация даты
	 * @param  String $field 
	 * @return errors      
	 */
	private static function date ($field){
		$data = self::$data[$field];
		$regex = self::$regexes[__FUNCTION__];

		if (!preg_match($regex, $data)) {
			self::$errors[$field][] = "Поле {$field} должо быть датой";
		}
	}
	/**
	 * Валидация email
	 * @param  String $field 
	 * @return errors      
	 */
	private static function email ($field){
		$data = self::$data[$field];

		if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
			self::$errors[$field][] = "Поле {$field} содержит некоректный email";
		}
	}
	/**
	 * Валидация поля содержащего только цифры
	 * @param  String $field 
	 * @return errors      
	 */
	private static function numeric ($field){
		$data = self::$data[$field];

		if (!is_numeric($data)) {
			self::$errors[$field][] = "Поле {$field} должно быть числом";
		}
	}
	/**
	 * Валидация поля содержащего только буквы
	 * @param  String $field 
	 * @return errors      
	 */
	private static function alpha ($field){
		$data = self::$data[$field];
		$regex = self::$regexes[__FUNCTION__];

		if (!preg_match($regex, $data)) {
			self::$errors[$field][] = "Поле {$field} должно содержать только буквы";
		}
	}
	/**
	 * Валидация поля содержащего только буквы или цифры
	 * @param  String $field 
	 * @return errors      
	 */
	private static function alphanumeriс ($field){
		$data = self::$data[$field];
		$regex = self::$regexes[__FUNCTION__];

		if (!preg_match($regex, $data)) {
			self::$errors[$field][] = "Поле {$field} должно содержать только буквы или цифры";
		}
	}
	/**
	 * Валидация поля содержащего только допустимые расширения изображения
	 * @param  String $field 
	 * @return errors      
	 */
	private static function image ($field){
		$data = self::$data[$field];
		$info = pathinfo($data);

		if (!isset($info['extension']) || !in_array($info['extension'], self::$allowedImageExtension)) {
			$fileAllowedStr = implode(', ', self::$allowedImageExtension);
			self::$errors[$field][] = "Поле {$field} содержит некорректное расширение файла допустимые расширения {$fileAllowedStr}";
		}
	}
	/**
	 * Валидация поля содержащего только допустимые расширения файла
	 * @param  String $field 
	 * @param  String $arg 
	 * @return errors      
	 */
	private static function mimes ($field, $arg){
		$data = self::$data[$field];
		$info = pathinfo($data);
		$arg = explode(',', $arg);

		if (!isset($info['extension']) || !in_array($info['extension'], $arg)) {
			$fileAllowedStr = implode(', ', $arg);
			self::$errors[$field][] = "Поле {$field} содержит некорректное расширение файла допустимые расширения {$fileAllowedStr}";
		}
	}




}
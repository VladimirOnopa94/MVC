<?php 
namespace framework\core\Auth;
use app\models\Auth\User;

trait Authenticate{    

	/*
		Аутентификация пользователя по полям переданым полям 
		password являеться обязательным полем по умолчанию  
		email являеться обязательным но может содержать и другое поле например login 
	*/
    public function Auth($credentials) {

        return true;
        return $credentials;
    } 

    /* 
    	Регистрация пользователя 
    */
    public function Register($credentials) {
        if (!self::checkUserExist($credentials)) {

            /*TODO*/
            
            //return $user; 
        }
        //return true;
        return null;    
        
    } 

    /*
        Проверка существует ли пользователь
    */
    public static function checkUserExist($data) {
        $user = new User;
        unset($data['password']);

        /*Если указано поле login*/
        if (array_key_exists('login', $data) ) {
            $user = $user->getUserByField('login', $data['login']); 
        }elseif (array_key_exists('email', $data)) { /*Если указано поле email*/
            $user = $user->getUserByField('email', $data['email']); 
        }
        if (!empty($user)) {
            return $user; 
        }
        return null; 
        
    }
    /*Проверка залогинен ли пользователь*/
    public static function checkAuth() {

    }
    /*Получение пользователя*/
    public static function user() {

    }
    /*Получение id пользователя*/
    public static function id() {

    }
}
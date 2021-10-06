<?php 
namespace framework\core\Auth;
use app\models\Auth\User;

trait Authenticate{    
    
	/*
		Аутентификация пользователя 
        $afterRegisteration - true  если вызов функции после регистрации, false если не после регистрации
	*/
    public function Auth($user, $afterRegisteration) {
         
        if (gettype($user) !== 'object') { /*Преоразовывем в объект если нужно*/
            $user = (object) $user;
        }
        /*Если вызов с страницы например логина проверим 
        есть ли такой пользователь если есть идем дальше иначе 
        возвращаем false */
        if (!$afterRegisteration) { 
            $userDb = self::getUserByName($user->name);
           
            if (empty($userDb) || $userDb->password !== md5($user->password)) {
                return false;
            }else{
                $user = $userDb;
            }
        }
        
        $userObj = new User;

        if ($user = $userObj->checkUserExist($user->name)) {

            unset($_SESSION['user']);
            if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
                $_SESSION['user']['name'] = $user->name; 
                $_SESSION['user']['user_id'] = $user->id; 
                return true;
            }
        }
        return null;    
    } 
   
    /*
        Проверка залогинен ли пользователь
    */
    public static function checkAuth() {
        if (isset($_SESSION['user']) || !empty($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return false;
    }

    /*
        Получение пользователя по id
    */
    public static function userById($id) {
        $user = new User;
        return $user->getUserById($id);
    }

    /*
        Получение пользователя по name
    */
    public static function getUserByName($name) {
        $user = new User;
        return $user->getUserByName($name);
    }
    /*
        Разлогинить юзера
    */
    public function logoutUser() {
        unset($_SESSION['user']);
        redirectBack();die;
    }
  
}
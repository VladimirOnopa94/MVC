<?php 
namespace framework\core\Auth;
use app\models\Auth\User;
use Exception;

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
            if (empty((array)$userDb) || $userDb->password !== md5($user->password)) {
                return 'Неверный логин или пароль';
            }else{
                $user = $userDb;
            }
        } 
        //действия после регистрации пользователя
        $userObj = new User;
        $userObj = $userObj->getUserByName($user->name);

        if ($user = (object) array_shift($userObj)) {
            unset($_SESSION['user']);
            if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
                $_SESSION['user']['name'] = $user->name; 
                $_SESSION['user']['user_id'] = $user->id; 
                $_SESSION['user']['role'] = 1;  //По умолчанию роль пользователя
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
        $user = $user->getUserById($id);

        return (object) array_shift($user);
    }

    /*
        Получение пользователя по name
    */
    public static function getUserByName($name) {
        $user = new User;
        $user = $user->getUserByName($name);

        return (object) array_shift($user);
    }
    /*
        Разлогинить юзера
    */
    public function logoutUser() {
        unset($_SESSION['user']);
        redirectBack();die;
    }

    /*
        Проверить роль пользователя
    */
    public function checkRole($role, $userRole) {
        $roles = config('roles.roles');
        if (isset($role) && isset($userRole)) {
            if ($roles[$role] !== intval($userRole)) {
               return false;
            }else{
                return true;
            }
        }
    }
  
}
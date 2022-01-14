<?php 

namespace app\components\modules;

use app\models\User;

class Identity
{
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

        return $user;
    }

    /*
        Получение пользователя по name
    */
    public static function userByName($name) {
        $user = new User;
        $user = $user->getUserByName($name);

        return $user;
    }
    /*
        Разлогинить юзера
    */
    public function logout() {
        unset($_SESSION['user']);
        redirectBack();die;
    }

    /*
        Проверить роль пользователя
    */
    public static function checkRole($role, $userRole) {
        $roles = config('roles.roles');
        if (isset($role) && isset($userRole)) {
            if ($roles[$role] !== intval($userRole)) {
               return false;
            }else{
                return true;
            }
        }
    }  
   /**
    * Проверка пароля
    * @param  string $password 
    * @param  string $hash     
    * @return boolean          
    */
    public static function validatePassword($password, $hash) {
        if (!password_verify($password, $hash)) {
            return false;
        }else{ 
            return true;
        }
    }
 	/**
    * Логин пользователя 
    * @param  array $user 
    * @return mixed          
    */
    public static function login($user) {
        if ($user) {
            unset($_SESSION['user']);
            if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
                $_SESSION['user']['name'] = $user['name']; 
                $_SESSION['user']['user_id'] = $user['id']; 
                $_SESSION['user']['role'] = $user['role'];  //По умолчанию роль пользователя
                return true;
            }
        }
        return false;     
    } 
}
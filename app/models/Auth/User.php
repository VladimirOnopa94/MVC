<?php 
namespace app\models\Auth;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
 */
class User extends \framework\core\Model
{

	protected $table = 'users';

	public function getUserByField($key, $value){

		return DB::table($this->table)
            ->select('*')   
            ->where($key, '=', $value)      
            ->get()
            ->toArray();
	}

	/*
		Создать нового пользователя
	*/
	public function createUser($data)
	{
		
        $id = DB::table($this->table)->insertGetId([
				    'email' => $data['email'],
				    'password' => md5($data['password']),
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
				]);

		return $id;
	}

	/*
        Проверка существует ли пользователь
    */
    public function checkUserExist($email) {
        return DB::table($this->table)
            ->select('*')   
            ->where('email', '=', $email)      
            ->first();
        
    }

	/*
        Получение пользователя по id
    */
    public function getUserById($id) {
        return DB::table($this->table)
            ->select('*')   
            ->where('id', '=', $id)      
            ->first();
    }

	 /*
        Получение пользователя по email
    */
    public function getUserByEmail($email) {
        return DB::table($this->table)
            ->select('*')   
            ->where('email', '=', $email)      
            ->first();
    }


}
<?php 
namespace app\models\Auth;


/**
 * 
 */
class User extends \framework\core\Model
{

	protected $table = 'users';

/*	public function testQuery($id,$country_id){

        $query = "SELECT * FROM {$this->table} ";
        
        $query .= " WHERE id = ?";
        $pararms[] = $id;

        if ($country_id == 8) {
            $query .= " AND country_id = ?";
            $pararms[] = $country_id;
        }

        if ($country_id == 8) {
            $query .= ' LIMIT 1';
        }

		 $result = $this->findBySql(
            $query, 
            $pararms
        );

         return $result;
	}*/

	/*
		Создать нового пользователя
	*/
	public function createUser($data)
	{
		
       
        return $this->query(
            "INSERT {$this->table} (name, password, created_at, updated_at)  VALUES (?, ?, ?, ?)", 
            [$data['name'], md5($data['password']), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]
        );

	}

	/*
        Проверка существует ли пользователь
    */
   /* public function checkUserExist($email) {

        return $this->findBySql("SELECT * FROM {$this->table} WHERE email = ? LIMIT 1", [$email]);
        
    }*/

	/*
        Получение пользователя по id
    */
    public function getUserById($id) {

        return $this->findOne($id);
    }

	 /*
        Получение пользователя по email
    */
    public function getUserByEmail($email) {

        return $this->findOne($email, 'email');
    }
     /*
        Получение пользователя по name
    */
    public function getUserByName($name) {

        return $this->findOne($name, 'name');       
    }


}
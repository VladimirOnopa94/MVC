<?php 
namespace app\models;
use app\models\Model;

/**
 * 
 */
class User extends Model
{

	protected $table = 'users';


	public function getUsers($page=1, $limit=10){

        $params['offsets'] = intval(($page-1) * $limit);

        $params['page'] = intval($limit); 

        $query = "SELECT * FROM `{$this->table}` LIMIT :page OFFSET :offsets";
        $result['result'] = $this->findBySql(
            $query, 
            $params
        );


        $query = "SELECT * FROM `{$this->table}` ";
        $result['total'] = $this->findBySql(
            $query 
        );

    
        
        /*$query .= " WHERE id = :id";
        $params['id'] = $ids; */
        

       /* if (!is_null($country)) {
            $params['country'] = $country; 
            $query .= " AND country_id = :country";
        }*/

		

         return $result;
	}

	/*
		Создать нового пользователя
	*/
	public function createUser($data, $role = 1)
	{
		
        $params = [
            'name' => $data['name'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' =>  $role,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]; 
        $id = $this->query(
            "INSERT {$this->table} (name, password, role, created_at, updated_at)  VALUES (:name, :password, :role, :created_at, :updated_at)", 
            $params
        );
        if (isset($id) && !empty($id)) { 
            return $id;
        }
        return false;
        
        

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
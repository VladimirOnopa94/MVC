<?php 
namespace app\models\Auth;


/**
 * 
 */
class User extends \framework\core\Model
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
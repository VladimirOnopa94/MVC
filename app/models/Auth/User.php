<?php 
namespace app\models\Auth;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
 */
class User extends \framework\core\Model
{

	protected $table = 'users';

	public function getUsersInformation(){

		return DB::table($this->table)
            ->select($this->table.'.*','country.name as country','country.id as cid')   
            ->leftJoin('countries as country', 'country.id', '=', $this->table.'.country_id')
            ->get();
	}

    //update user info
    public function saveUserInformation($user_id, $data){
        $publish = '0';
        //update user table
        if (isset($data->publish_contact)) {
            $publish = '1';
        }
        DB::table($this->table)
        ->where($this->table.'.id', $user_id)
        ->update([
            'name' => $data->firstname, 
            'lastname' => $data->lastname, 
            'address' => $data->address, 
            'city' => $data->city, 
            'country_id' => $data->country, 
            'publish_contact' => $publish, 
        ]);

        //update user phones

        DB::table('phones')->where('user_id', '=', $user_id)->delete();

        foreach ($data->phone as $key => $phone) {
            $is_show = '0';
            if (isset($phone['is_show'])) {
                $is_show = '1';
            }

            DB::table('phones')->insert([
                'user_id' => $user_id,
                'phone' => $phone['value'],
                'is_show' => $is_show
            ]);
        }

        //update user emails

        DB::table('emails')->where('user_id', '=', $user_id)->delete();

        foreach ($data->email as $key => $email) {
            $is_show = '0';
            if (isset($email['is_show'])) {
                $is_show = '1';
            }

            DB::table('emails')->insert([
                'user_id' => $user_id,
                'email' => $email['value'],
                'is_show' => $is_show
            ]);
        }

    }

    public function getUserPhones($user_id, $status){

        return DB::table($this->table)
            ->select('phones.*')   
            ->leftJoin('phones', 'phones.user_id', '=', $this->table.'.id')
            ->where($this->table.'.id', '=', $user_id)  
            ->whereIn($this->table.'.publish_contact', $status) 
            ->get()
            ->toArray();
    }

    public function getUserEmails($user_id, $status){

        return DB::table($this->table)
             ->select('emails.*')   
            ->leftJoin('emails', 'emails.user_id', '=', $this->table.'.id')
            ->where($this->table.'.id', '=', $user_id)   
            ->whereIn($this->table.'.publish_contact', $status) 
            ->get()
            ->toArray();
    }

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
	/*public function createUser($data)
	{
		
        $id = DB::table($this->table)->insertGetId([
				    'email' => $data['email'],
				    'password' => md5($data['password']),
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
				]);

		return $id;
	}*/

	/*
        Проверка существует ли пользователь
    */
    public function checkUserExist($name) {
        return DB::table($this->table)
            ->select('*')   
            ->where('name', '=', $name)      
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
     /*
        Получение пользователя по name
    */
    public function getUserByName($name) {
        return DB::table($this->table)
            ->select('*')   
            ->where('name', '=', $name)      
            ->first();
    }


}
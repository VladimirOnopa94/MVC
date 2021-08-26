<?php 
namespace app\models\Auth;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
 */
class User extends \framework\core\Model
{
	protected $table = 'oc_user';

	public function getUserByField($key, $value){

		$users = DB::table('oc_user AS p')
            ->select('*')            
            ->get();
//var_dump($users);


	}


}
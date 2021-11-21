<?php 
namespace app\controllers\Site;

use app\models\Auth\User;
use app\models\Category;
use app\controllers\Controller;
use framework\core\App;


class UsersListController extends Controller{ 

	public $csrf = false; 

	public function index($request)
	{

		$this->language('index');
		$this->setTitle('Главная');

		$page = App::request()->get('page', 1);
		$limit = 5;
		$users = new User;
		$users = $users->getUsers($page,$limit);

		$total = (isset($users['total'])) ? count($users['total']) : [] ;
		$users = (isset($users['result'])) ? $users['result'] : [] ;

		$this->render('users_list' , compact('total', 'page', 'limit', 'users'));
	}

}
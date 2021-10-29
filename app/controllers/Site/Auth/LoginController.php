<?php 
namespace app\controllers\Site\Auth;


use app\models\Index;
use app\controllers\Controller;
//use app\components\events\RegisterUserEvent;
use framework\core\Validate as VD;


class LoginController extends Controller{ 


	public $csrf = true;

	/*public function __construct(){
		$this->Middleware(new \app\components\middlewares\UserMiddleware(['Login']));
		$this->Middleware(new \app\components\middlewares\RoleCheckMiddleware());
		parent::__construct();
	}*/

	public function Index($request)
	{

		//$array = ['data'=>'value'];

		//new RegisterUserEvent($array,'test');

		$this->setTitle('Вход');
		
		$this->render('Auth/AuthLogin');
	}
	
	/*
		Обработка логина пользователя
	*/
	public function Login()
	{
		if (isset($_POST)) {

			$credentials = array('name' => $_POST['name'] , 'password' => $_POST['password']);

			VD::load($credentials);

			$errors = VD::validate([
				'name' => 'required' , 
				'password' => 'required' , 
			]); 
			
			if (empty($errors)) {
				$response = $this->Auth($credentials, false);
				
				if (is_bool($response) === true) {
					flashMessage('success', 'Успешно вошли');
					redirect('/');
				}else{
					flashMessage('error', $response);
					redirect('/login');exit;
				}
	
			}else{
				flashMessage('error', implode('<br>', $errors));
				redirect('/login');exit;
			}
			
		}

	}

	public function Logout() /*TODO*/
	{
		$this->logoutUser();
	}


	
}
<?php 
namespace app\controllers\Site\Auth;


use app\models\Index;
use framework\core\Controller;
use framework\core\Validate as VD;


class LoginController extends Controller{ 


	public $csrf = true;

	public function __construct(){
		$this->Middleware(new \framework\middlewares\UserMiddleware(['Login']));
		$this->Middleware(new \framework\middlewares\RoleCheckMiddleware());
		parent::__construct();
	}

	public function Index()
	{
		
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
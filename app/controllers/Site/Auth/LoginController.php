<?php 
namespace app\controllers\Site\Auth;


use app\models\Auth\User;

use app\controllers\Controller;
//use app\components\events\RegisterUserEvent;
use framework\core\Validate as VD;
use framework\core\App;
use framework\core\Image;
use app\components\widgets\Breadcrumbs;




class LoginController extends Controller{ 


	public $csrf = true;

	public function __construct(){
		//$this->Middleware(new \app\components\middlewares\UserMiddleware(['Login']));
		//$this->Middleware(new \app\components\middlewares\RoleCheckMiddleware(['Login']));
		//$this->Middleware(new \app\components\middlewares\LoginAttemptsMiddleware(['Login']));
		parent::__construct();
	}

	public function Index($request)
	{

		//$array = ['data'=>'value'];

		//new RegisterUserEvent($array,'test');
		
		$this->language('login');

    	Breadcrumbs::$param['breadcrumbs'][] = array('name' => __('login_title') );
  


		$this->setTitle('Вход');
		
		$this->render('Auth/AuthLogin');

		
	}
	public function TestPage($request)
	{

		$this->setTitle('TEST');
		
		$this->render('Auth/AuthLogin');
	}
	
	/*
		Обработка логина пользователя
	*/	
	public function Login($request)
	{
		
		if ($data = App::$app->request->post()) {
	

			$credentials = array('name' => $data['name'] , 'password' => $data['password'] , 'file' => $_FILES);

			$errors = VD::load($credentials)->validate([
				'name' => 'required' , 
				'password' => 'required' , 
				'file' => 'image' , 

			]); 

			/*foreach ($_FILES as $key => $file) {
				$path = CATALOG . '/image/new_img' . microtime() . '.webp';
				Image::create($file)->save($path);
			}*/

			if (empty($errors)) {
				$response = $this->Auth($credentials, false);
				
				if (is_bool($response) === true) {
					flashMessage('success', 'Успешно вошли');
					redirect('/');
				}else{
					(!isset($_SESSION['loginAttemptCount'])) ? $_SESSION['loginAttemptCount'] = 1 : '';

					flashMessage('error', $response);
					redirect('/login');exit;
				}
	
			}else{
				flashMessage('error', implode('<br>', $errors));
				redirect('/login');exit;
			}
			
		}

	}

	public function Logout() 
	{
		$this->logoutUser();
	}


	
}
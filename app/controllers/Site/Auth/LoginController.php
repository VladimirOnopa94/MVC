<?php 
namespace app\controllers\Site\Auth;


use app\models\User;

use app\controllers\Controller;
//use app\components\events\RegisterUserEvent;
use framework\core\Validate as VD;
use framework\core\App;
use framework\core\Image;
use framework\core\File;
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
		$this->language('login');
		
		if ($data = App::$app->request->post()) {
	

			$credentials = array('name' => $data['name'] , 'password' => $data['password'] , 'file' => $_FILES);

			$errors = VD::load($credentials)->validate([
				'name' => 'required' , 
				'password' => 'required' , 
				//'file' => 'mimes:pdf,doc,docx' 

			]); 
			
			/*foreach ($_FILES as $key => $file) {
				$path = IMAGE;
				$name = 'new_img' . microtime();

				Image::create($file)->encode("webp", 10)->save($path);
			}*/

			if (empty($errors)) {

				$user = App::$app->user->userByName($credentials['name']);

				if (App::$app->user->validatePassword($credentials['password'], $user['password'])) {
					if (App::$app->user->login($user) === true) {

						flashMessage('success', 'Успешно вошли');
						redirect(route('main'));
					}else{
						(!isset($_SESSION['loginAttemptCount'])) ? $_SESSION['loginAttemptCount'] = 1 : '';

						flashMessage('error', 'Что то пошло не так');
						redirect(route('/login'));exit;
					}
				}else{
					flashMessage('error',  __('wrong_pass'));
					redirect(route('/login'));exit;
				}
	
			}else{
				flashMessage('error', implode('<br>', $errors));
				redirect(route('/login'));exit;
			}
			
		}

	}

	public function Logout() 
	{
		App::$app->user->logout();
	}


	
}
<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use framework\core\Controller;
use framework\core\Validate as VD;

class LoginController extends Controller{ 


	//public $csrf = false;

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

			$credentials = array('name' => $_POST['name'] , 'password' => $_POST['password'], 'file' => $_POST['file']);

			VD::load($credentials);

			$errors = VD::validate([
				'name' => 'required|alphanumeriс' , 
				'password' => 'required|max:10|min:2' , 
				'file' => 'required|mimes:xml,jpg' , 
			]); 
			
			if (empty($errors)) {
				if ($this->Auth($credentials, false)) {
					flashMessage('success', 'Успешно вошли');
					redirect('/');
				}else{
					flashMessage('error', 'Что то пошло не так');
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
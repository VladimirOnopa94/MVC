<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use framework\core\Controller;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class LoginController extends Controller{ 


	//public $csrf = false;

	public function Index()
	{
		$this->setTitle('Вход');
		
		$this->render('Auth/AuthLogin');
	}

	public function Login()
	{
		
		if (isset($_POST)) {

			$credentials = array('email' => $_POST['email'] , 'password' => $_POST['password']);

			$validator = v::key('email', v::email()->notEmpty())
                    	->key('password', v::length(6,null));
			try {
				$validator->assert($credentials);

				if ($this->Auth($credentials, false)) {
					flashMessage('success', 'Успешно вошли');
					redirect('/');
				}
				
			} catch(NestedValidationException $exception) {
			   print_r($exception->getMessages());
			}
			
		}

	}

	public function Logout() /*TODO*/
	{
		$this->logoutUser();
	}


	
}
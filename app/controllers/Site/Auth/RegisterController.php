<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use framework\core\Controller;
use framework\core\Auth\Authenticate;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class RegisterController extends Controller{ 

	use Authenticate;

	public function index()
	{
		$this->render('Auth/AuthRegister');
	}

	public function signup()
	{
		if (isset($_POST)) {

			$credentials = array('email' => $_POST['email'] , 'password' => $_POST['password']);

			$validator = v::key('email', v::email()->notEmpty())
                    	->key('password', v::length(6,null));
			try {
				$validator->assert($credentials);

				if ($this->Register($credentials)) {
					var_dump("s");
				}
				
			} catch(NestedValidationException $exception) {
			   print_r($exception->getMessages());
			}
			
		}
		
	}


	
}
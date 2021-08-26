<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use framework\core\Controller;
use framework\core\Auth\Authenticate;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class LoginController extends Controller{ 

	use Authenticate;

	//public $csrf = false;

	public function index()
	{
		$this->render('Auth/AuthLogin');
	}

	public function Login()
	{
		
		//var_dump($request);
		if (isset($_POST)) {

			$credentials = array('email' => $_POST['email'] , 'password' => $_POST['password']);

			$validator = v::key('email', v::email()->notEmpty())
                    	->key('password', v::length(6,null));
			try {
				$validator->assert($credentials);

				if ($this->Auth($credentials)) {
					var_dump("s");
				}
				
			} catch(NestedValidationException $exception) {
			   print_r($exception->getMessages());
			}
			
		}

	}


	
}
<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use app\controllers\Controller;
use app\components\widgets\Breadcrumbs;
use framework\core\Validate as VD;
use framework\core\Mail;
use app\models\User;
use framework\core\App;


class RegisterController extends Controller{ 

	/*
		Отображение страницы регистрации
	*/
	public function Index()
	{
		Breadcrumbs::$param['breadcrumbs'][] = array('name' => 'Регистрация' );
		
		$this->setTitle('Регистрация');

		$this->render('Auth/AuthRegister');
	}

	/*
		Прием данных с формы регистрации
	*/
	public function Signup($request)
	{
		$data = App::$app->request->post();

		if (isset($data['name']) && isset($data['password'])) {

			$credentials = array('name' => $data['name'] , 'password' => $data['password']);

			$errors = VD::load($credentials)->validate([
				'name' => 'required' , 
				'password' => 'required' , 
			]); 

			if (empty($errors)) {
				if (empty((array) App::$app->user->userByName($credentials['name']))) { /*Проверка есть ли такой пользователь*/	

					$user = $this->Register($credentials, 1);

					if ($user && App::$app->user->login($user)) { /*Если нет  ошибок при регистрации, логинем юзера*/
						flashMessage('success', 'Вы успешно зарегистрировались');
						redirect(route('main'));

					}else{
						flashMessage('error', 'Ошибка');
						redirectBack();
					}
				}else{
					flashMessage('error', 'Такой пользользователь уже существует');
					redirectBack();
				}

			}else{
				flashMessage('error', implode('<br>', $errors));
				redirectBack();
			}

		}

	}

	/* 
    	Регистрация пользователя 
    */
    public function Register($credentials, $role) 
    {
    	$userObj = new User;
        $id = $userObj->createUser($credentials, $role); 
        
        if ($id !== false) {  
            return $userObj->getUserById($id);
        }
        return false;      
    } 


/*	public function sendMailToUser() 
    {
    	$var1 = 1;
		$mail = new Mail();
		$mail->subject('Register')
			 ->to('wowaonopa1991@gmail.com')
			 ->view('mail/mail')
			 ->data(compact('var1'))
			 ->send();
    }
*/


} 
<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use app\controllers\Controller;
use app\components\widgets\Breadcrumbs;
use framework\core\Validate as VD;
use framework\core\Mail;
use app\models\Auth\User;


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
		if (isset($request->name) && isset($request->password)) {

			$credentials = array('name' => $request->name , 'password' => $request->password);

			VD::load($credentials);

			$errors = VD::validate([
				'name' => 'required' , 
				'password' => 'required' , 
			]); 

			if (empty($errors)) {
				if (empty((array) $this->getUserByName($credentials['name']))) { /*Проверка есть ли такой пользователь*/	

					$user = $this->Register($credentials);

					if ($user && $this->Auth($user, true)) { /*Если нет  ошибок при регистрации, логинем юзера*/

						
						flashMessage('success', 'Вы успешно зарегистрировались');
						redirect('/');

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
    public function Register($credentials) 
    {
    	$userObj = new User;
        $id = $userObj->createUser($credentials); 
        
        if (isset($id) && !empty($id)) {           
            return $this->userById($id);
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
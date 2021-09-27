<?php 
namespace app\controllers\Site\Auth;

use app\models\Index;
use framework\core\Controller;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use app\models\Auth\User;


class RegisterController extends Controller{ 

	/*
		Отображение страницы регистрации
	*/
	public function Index()
	{

		
		$this->setTitle('Регистрация');
		
		$this->render('Auth/AuthRegister');
	}

	/*
		Прием данных с формы регистрации
	*/
	public function Signup($request)
	{
		if (isset($request->email) && isset($request->password)) {

			$credentials = array('email' => $request->email , 'password' => $request->password);

			$validator = v::key('email', v::email()->notEmpty())
                    	->key('password', v::length(6,null));
			try {
				$validator->assert($credentials);

				if (!$this->userByEmail($credentials['email'])) { /*Проверка есть ли такой пользователь*/	
					$user = $this->Register($credentials);
					if ($user && $this->Auth($user, true)) { /*Если нет  ошибок при регистрации, логинем юзера*/

						$this->sendMailToUser();
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
				
			} catch(NestedValidationException $exception) {
				flashMessage('error', implode(', ', $exception->getMessages()));
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


	public function sendMailToUser() 
    {
    	$var = 'Информация';

    	$headers = "Content-Type: text/html; charset=UTF-8\r\n";

    	$this->sendMail(
    		'Тема фреймоврк', //тема письма  
    		'Текст письма', //Текст если не указан шаблон
    		['wowaonopa1991@gmail.com'], //получатели письма
    		$headers, //Заголовки письма
    		'', //шаблон письма 
    		''	//Переменные в шаблон письма
    	);
    	
    }


	
}
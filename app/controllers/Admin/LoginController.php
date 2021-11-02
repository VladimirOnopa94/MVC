<?php 
namespace app\controllers\Admin;


use app\controllers\Controller;




class LoginController extends Controller{ 


	public function Index($request)
	{

		$this->setTitle('Вход');
		echo "admin";
		//$this->render('Auth/AuthLogin');
	}


	
}
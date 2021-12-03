<?php 
namespace app\controllers\Admin;


use app\controllers\Controller;




class LoginController extends Controller{ 


	public $layout = 'admin2';
	public function Index($request)
	{
		//$this->layout = 'admin';
		$this->setTitle('Вход');
		$this->render('index');
	}


	
}
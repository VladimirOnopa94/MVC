<?php 
namespace framework\core\Error;

use framework\core\Controller;

class ErrorController extends Controller{ 


	public function ShowError()
	{
		$this->setTitle('404');
		
		$this->render('404');
	}
	

	
}
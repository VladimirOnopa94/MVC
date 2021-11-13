<?php 
namespace framework\core\Error;

use framework\core\Controller;

class ErrorController extends Controller{ 


	public function ShowError()
	{
		$this->setTitle('404');
		
		$this->render('404');
	}
	
	public function ShowForbbiden()
	{
		abort(403);
		
		$this->setTitle('403');
		
		$this->render('403');
	}
	

	
}
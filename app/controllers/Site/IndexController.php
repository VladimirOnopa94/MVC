<?php 

namespace app\controllers\Site;
use  app\models\Index;

class IndexController extends \framework\core\Controller{ 

	public function index()
	{
		$page = "main page";

		//$this->logger->log('Успех!' , 'success_register');
		$this->render('index' , compact('page'));
	}


	public function Product($request)
	{

	}

	public function Category($request)
	{
		$category = "cat 1";

		$index = new Index();

		$data = $index->getUser($request->catAlias);

		
		
		$this->render('category/index' , compact('category'));

	}
	
}
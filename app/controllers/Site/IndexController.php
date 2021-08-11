<?php 

namespace app\controllers\Site;
use app\models\Index;


class IndexController extends \framework\core\Controller{ 

	public function index()
	{
		$page = "main page";

		$this->render('index' , compact('page'));
	}


	public function Product($request)
	{

	}

	public function Category($request)
	{
		//$category = "cat 1";

		$index = new Index();

		$categorys = $index->getCategory($request->id);

		//dd($category);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
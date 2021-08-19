<?php 

namespace app\controllers\Site;
use app\models\Index;
use framework\core\Controller;

class IndexController extends Controller{ 

	public function index()
	{
		$page = "main page";
		$this->language('index');
		$this->render('index' , compact('page'));
	}


	public function Product($request)
	{
		echo "Product";

	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
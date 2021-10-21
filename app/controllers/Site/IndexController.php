<?php 
namespace app\controllers\Site;

use app\models\Category;
use app\controllers\Controller;

class IndexController extends Controller{ 

	public $csrf = false; 

	public function index()
	{

		$page = "Главная";
		$this->language('index');
		$this->setTitle('Главная');
		
		$this->render('index' , compact('page'));
	}


	public function Product($request)
	{
		echo "Product";
	}

	public function Page($request)
	{
		echo "Page";
	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
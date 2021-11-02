<?php 
namespace app\controllers\Site;

use app\models\Category;
use app\controllers\Controller;
use framework\core\App;

class IndexController extends Controller{ 

	public $csrf = false; 

	public function index($request)
	{

		$page = "Главная"; 
		$var1 = "test2"; 
		$this->language('index');
		$this->setTitle('Главная');

		//var_dump(App::request()->get('test'));

		$this->render('index' , compact('page','var1'));
	}

	public function Api($request)
	{

		var_dump("api");
	}


	public function Product($request)
	{

		echo "Product";
	}

	public function Page($request)
	{
		echo "s";
	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
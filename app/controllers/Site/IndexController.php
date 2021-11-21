<?php 
namespace app\controllers\Site;

use app\models\Auth\User;
use app\models\Category;
use app\controllers\Controller;
use framework\core\App;


class IndexController extends Controller{ 

	public $csrf = false; 

	public function index($request)
	{

		$this->language('index');
		$this->setTitle('Главная');
		
		$this->render('index');
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
		/*$page = "Главная"; 
		$var1 = "test2";
		$this->language('index');
		echo  $this->render('index' , compact('page','var1'), true);die;*/
		
	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
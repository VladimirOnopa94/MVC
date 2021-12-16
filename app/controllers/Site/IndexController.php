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

		/*if (!$data = App::component('cache')->get('test')) {
			
		}*/ 

		
		$this->language('index');
		$this->setTitle('Главная');
		
		$this->render('index');
	}
	
	public function Api($request)
	{
		//if ($data = App::request()->post()) {

			//App::$app->logger->log(json_encode($data) , 'success_register');
		//}
	}
	public function Page($request)
	{
		echo "page";
	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
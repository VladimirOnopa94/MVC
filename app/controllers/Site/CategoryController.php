<?php 
namespace app\controllers\Site;

use app\models\Category;
use framework\core\Controller;

class CategoryController extends Controller{ 

	
	public function Index()
	{
		$this->language('index');
		$this->setTitle('Категории');

		$categories = new Category;
		if ($categories = $categories->getCategories()) {
			$this->render('category/list-categories' , compact('categories'));
		}else{
			abort(404);
			$this->render('404');
		}
	}

	public function Category($requset)
	{
		$this->language('index');

		$category = new Category;

		if (!empty($category->getCategory($requset->slug))) {
			$category = $category->getCategory($requset->slug);
			$this->setTitle($category->name);
			$this->render('category/category' , compact('category'));
		}else{
			abort(404);
			$this->render('404');
		}

		
	}


	
}
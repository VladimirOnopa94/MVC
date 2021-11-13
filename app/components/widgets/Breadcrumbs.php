<?php 

namespace app\components\widgets;
use framework\core\Widget;

class Breadcrumbs extends Widget{ 

	public  function run($breadcrumbs)
	{
		if (isset($breadcrumbs) && !is_null(Widget::$param['breadcrumbs'])) {
			array_unshift(Widget::$param['breadcrumbs'], $breadcrumbs); 
		}

		if ($breadcrumbs = Widget::$param['breadcrumbs']) {
			$i = 0;
			$numItems = count($breadcrumbs);
			foreach ($breadcrumbs  as $key => $value) {
				$href = '';
				if (isset($value['href'])) {
					$href = $value['href'];
				}
				$result['breadcrumbs'][$key]['name'] = $value['name'];
				$result['breadcrumbs'][$key]['href'] = $href;
				if(++$i != $numItems) {
				    $result['breadcrumbs'][$key]['delimiter'] = '>';
				}  
		   } 
		}

		$result['view'] = 'breadcrumbs';

		return $result;
	}


	
}
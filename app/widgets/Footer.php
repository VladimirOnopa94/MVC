<?php 

namespace app\widgets;
use framework\core\Widget;

/*
$data['data'] = array('1','2'); не обязательній параметр данных для вида
$data['view'] = 'widgets/sidebar' обязательный параметр , передаем путь к виду виджета;
*/

class Footer extends \framework\core\Widget{ 

	public  function run()
	{
		$data['footer_data'] = 'footer_data';
		$data['view'] = 'widgets/footer';

		return $data;
	}


	
}
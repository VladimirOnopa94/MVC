<?php 

namespace framework\widgets;
use framework\core\Widget;


/*
$data['data'] = array('1','2'); не обязательный параметр данных для вида
$data['view'] = 'widgets/sidebar' обязательный параметр , передаем путь к виду виджета;
*/

class Header extends \framework\core\Widget{ 

	public  function run()
	{
		$data['title'] = 'Header';
		$data['view'] = 'header';
		$this->language('header');

		return $data;
	}


	
} 
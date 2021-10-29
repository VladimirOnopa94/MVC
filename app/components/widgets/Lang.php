<?php 

namespace app\components\widgets;
use framework\core\Widget;


/*
$data['data'] = array('1','2'); не обязательный параметр данных для вида
$data['view'] = 'widgets/sidebar' обязательный параметр , передаем путь к виду виджета;
*/

class Lang extends \framework\core\Widget{ 

	public  function run()
	{
		$langSettings = config_get('kernel.language');

		if ($langSettings && count($langSettings['langs']) > 1) {
			$data['langs'] = $langSettings['langs'];
		}else{
			$data['langs'][] = array_shift($langSettings['langs']);
		}
		
		$data['view'] = 'lang';

		return $data;
	}


	
} 
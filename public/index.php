<?php 

use framework\core\Router;

// Configuration
if (is_file(dirname(__DIR__). '/config/config.php')) {
	require_once(dirname(__DIR__).'/config/config.php');
}
 
require_once ROOT.'/vendor/framework/core/Functions.php';

/*spl_autoload_register(function($class){
	
	$file = ROOT .'/'.str_replace('\\', '/', $class).'.php';

	if(is_file($file)){
		require_once $file;
	}

});*/

require __DIR__ . '/../vendor/autoload.php';

new Router();


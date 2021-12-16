<?php 

// Configuration
if (is_file(dirname(__DIR__) . '/config.php')) { 
	require_once(dirname(__DIR__) . '/config.php');
}
require_once ROOT . '/vendor/framework/core/Functions.php';

require __DIR__ . '/../vendor/autoload.php';

new framework\core\App();

framework\core\Route\Router::instance();



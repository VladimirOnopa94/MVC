<?php 

framework\core\Router::group(['prefix' => 'panel_adm'], function(){ 
	return [
		'/login' 				=> 'Admin\LoginController@Index',
	];
});


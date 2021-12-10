<?php 

framework\core\Router::group(['prefix' => 'api'], function(){ 
	return [
		'/googleFormInput' => 'Site\IndexController@Api',
	];
});


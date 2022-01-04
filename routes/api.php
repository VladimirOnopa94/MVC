
<?php 
use framework\core\Route\Route;

Route::group(['prefix' => 'api'], function(){ 

		Route::get('/googleFormInput' , 'Site\IndexController@Api');
		Route::get('/getUserStat' , 'Site\IndexController@ApiStat');
		
});


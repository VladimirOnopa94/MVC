<?php 
use framework\core\Route\Route;


Route::group(['suffix' => '.html', 'prefix' => getLang(true)], function(){ 

		Route::get('' 						, 'Site\IndexController@Index')->name('main');
		/*login*/
		Route::get('/login' 				, 'Site\Auth\LoginController@Index');
		Route::get('/category/{category}/{post}' 	, 'Site\Auth\LoginController@TestPage')->name('category.product');
		Route::get('/category/{category}' 	, 'Site\Auth\LoginController@TestPage')->name('category.view');
		Route::get('/logout' 				, 'Site\Auth\LoginController@Logout');
		Route::post('/signin' 				, 'Site\Auth\LoginController@Login');
		/*register*/
		Route::get('/register' 			, 'Site\Auth\RegisterController@Index',);
		Route::post('/signup' 				, 'Site\Auth\RegisterController@Signup');
		/*pages*/
		Route::get('/users' 				, 'Site\UsersListController@Index');
		Route::get('/mycontact' 			, 'Site\MycontactController@Index');
		Route::get('/offline' 		    	, 'Site\MaintenanceController@inWork');
});



Route::get('contact', 'Site\IndexController@Index');
Route::get('/phonebook' 			, 'Site\IndexController@Page');

Route::post('contact-post', 'Site\IndexController@Index');

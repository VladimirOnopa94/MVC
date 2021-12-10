<?php 
framework\core\Router::group(['prefix' => ''], function(){ 
	return [
		'' 						=> 'Site\IndexController@Index',
		/*login*/
		'/login' 				=> 'Site\Auth\LoginController@Index',
		'/category/{category}/{post}' 	=> 'Site\Auth\LoginController@TestPage',
		'/logout' 				=> 'Site\Auth\LoginController@Logout',
		'/signin' 				=> 'Site\Auth\LoginController@Login',
		/*register*/
		'/register' 			=> 'Site\Auth\RegisterController@Index', 
		'/signup' 				=> 'Site\Auth\RegisterController@Signup',
		/*pages*/
		'/users' 				=> 'Site\UsersListController@Index',
		'/phonebook' 			=> 'Site\IndexController@Page',
		'/mycontact' 			=> 'Site\MycontactController@Index',
		'/savecontact' 			=> 'Site\MycontactController@Store',
		'/offline' 		    	=> 'Site\MaintenanceController@inWork',
	];
});


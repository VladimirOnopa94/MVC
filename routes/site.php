<?php 

return [
	'{lang}' 					=> 'Site\IndexController@Index',
	/*login*/
	'{lang}/login' 				=> 'Site\Auth\LoginController@Index',
	'{lang}/category/{category}/{post}' 			=> 'Site\Auth\LoginController@TestPage',
	'{lang}/logout' 			=> 'Site\Auth\LoginController@Logout',
	'{lang}/signin' 			=> 'Site\Auth\LoginController@Login',
	/*register*/
	'{lang}/register' 			=> 'Site\Auth\RegisterController@Index', 
	'{lang}/signup' 			=> 'Site\Auth\RegisterController@Signup',
	/*pages*/
	'{lang}/users' 				=> 'Site\UsersListController@Index',
	'{lang}/phonebook' 			=> 'Site\IndexController@Page',
	'{lang}/mycontact' 			=> 'Site\MycontactController@Index',
	'{lang}/savecontact' 		=> 'Site\MycontactController@Store',
	'{lang}/offline' 		    => 'Site\MaintenanceController@inWork',


];


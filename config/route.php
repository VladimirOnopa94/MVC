<?php 

return [
	'{lang}' 								    => 'Site\IndexController@Index',
	'{lang}/page' 								=> 'Site\IndexController@Page',
	//'{lang}/category/{slug}/{post-slug}'		=> 'Site\CategoryController@Product',
	'{lang}/category/{slug}'					=> 'Site\CategoryController@Category',
	'{lang}/categories' 						=> 'Site\CategoryController@Index',
	/*login*/
	'{lang}/login' 								=> 'Site\Auth\LoginController@Index',
	'{lang}/logout' 							=> 'Site\Auth\LoginController@Logout',
	'{lang}/signin' 							=> 'Site\Auth\LoginController@Login',
	/*register*/
	'{lang}/register' 							=> 'Site\Auth\RegisterController@Index', 
	'{lang}/signup' 							=> 'Site\Auth\RegisterController@Signup',
];


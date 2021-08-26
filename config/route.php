<?php 

return [
	'{lang}' 								    => 'Site\IndexController@Index',
	'{lang}/page/some' 								    => 'Site\IndexController@Page',
	'{lang}/category/{catAlias}/{prodAlias}'	=> 'Site\IndexController@Product',
	'{lang}/category/{id}' 						=> 'Site\IndexController@Category',
	/*login*/
	'{lang}/login' 								=> 'Site\Auth\LoginController@index',/*TODO*/
	'{lang}/signin' 							=> 'Site\Auth\LoginController@Login',/*TODO*/
	/*register*/
	'{lang}/register' 							=> 'Site\Auth\RegisterController@index', /*TODO*/
	'{lang}/signup' 							=> 'Site\Auth\RegisterController@signup',/*TODO*/
];


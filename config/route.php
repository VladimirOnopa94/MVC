<?php 

return [
	'{lang}' 								    => 'Site\IndexController@Index',
	/*login*/
	'{lang}/login' 								=> 'Site\Auth\LoginController@Index',
	'{lang}/logout' 							=> 'Site\Auth\LoginController@Logout',
	'{lang}/signin' 							=> 'Site\Auth\LoginController@Login',
	/*pages*/
	'{lang}/phonebook' 							=> 'Site\PhonebookController@Index',
	'{lang}/mycontact' 							=> 'Site\MycontactController@Index',
	'{lang}/savecontact' 						=> 'Site\MycontactController@Store',

];


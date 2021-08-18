<?php 

return [
	'' 								    => 'Site\IndexController@Index',
	'category/{catAlias}/{prodAlias}'	=> 'Site\IndexController@Product',
	'category/{id}' 					=> 'Site\IndexController@Category',
	'language/{code}' 					=> 'Site\LangController@SetLang',
];


<?php 

return [
	'' 								    => 'Site\IndexController@Index',
	'category/{catAlias}/{prodAlias}'	=> 'Site\IndexController@Product',
	'category/{catAlias}' 				=> 'Site\IndexController@Category',
];


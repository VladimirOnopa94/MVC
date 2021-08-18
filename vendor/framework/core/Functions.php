<?php 

function dd($var){ 
	echo "<pre>";
	print_r($var);
	exit;
}

function __($key)
{
	return \framework\core\Language::get($key);
}
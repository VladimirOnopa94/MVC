<?php 

namespace app\controllers;

use framework\core\View;

//use framework\core\Registry;

class Controller extends \framework\core\Controller
{
    //public $cart; // это свойство будет доступно во всех контроллерах 


    function __construct(){
        //$this->cart = 'somedata';   
        //$this->cart = 'somedata';   
    	//Registry::set('cart', 'test'); //Установим свойство доступное с любой точки приложения

        parent::__construct();
    }
}
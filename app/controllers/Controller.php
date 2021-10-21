<?php 

namespace app\controllers;

use framework\core\View;

class Controller extends \framework\core\Controller
{
    //public $cart; // это свойство будет доступно во всех контроллерах 

    function __construct(){
        //$this->cart = 'somedata';   

        parent::__construct();
    }
}
<?php 

namespace app\controllers;

use framework\core\View;

class Controller extends \framework\core\Controller
{
    //public $cart; // это свойство будет доступно во всех контроллерах 
    public $global_vars ;   

    function __construct(){
        
        //$this->cart = 'somedata';   
        $this->global_vars['footer_data'] = 'somedata';    

        parent::__construct();
    }
}
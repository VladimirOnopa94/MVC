<?php 

namespace app\components\events;

use framework\core\Event;

class RegisterUserEvent extends Event
{
	//public $data;

    public function __construct($data='')
    {
    	parent::__construct($data);
    }

}
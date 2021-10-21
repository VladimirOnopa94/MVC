<?php 

namespace app\components\events;

use framework\core\Event;

class RegisterUserEvent extends Event
{

	public $data;
	public $text;
	
    public function __construct()
    {
    	$this->data = $data;
    	$this->text = $text;
    	parent::__construct($this->text,$this->data);
    }

}
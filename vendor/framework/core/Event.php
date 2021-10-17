<?php 

namespace framework\core;
use Exception;

/*
Класс события, полуает вызываемое собитые, переданые параметры (если есть),
назначает обработчики которые установлены в файле событий-обработчиков
*/ 
abstract class Event 
{
	private $eventsList = [];
	private $data ;

    public function __construct($data=''){

    	$this->data = $data;
    	$this->eventsList = require CONFIG . '/events.php' ; //файл событий-обработчиков
    	$event = get_called_class();

    	if (!array_key_exists($event, $this->eventsList)) {
    		throw new Exception("Event not exist in events.php" );
    	}else{
    		$this->callListener($event);
    	}
    }

    /*
   		 Метод вызова слушателей события
    */
    private function callListener($event){

    	foreach ($this->eventsList[$event] as $key => $listenerClass) {
    		try{
				if (class_exists($listenerClass)) {
					$listner = new $listenerClass();
					$listner->handle($this->data);
	    		}else{
	    		 	throw new Exception("Listener class {$listenerClass}  not found " );
	    		}
			}catch (Exception $ex) {
				    echo $ex->getMessage();
			}
    	}
    }


}
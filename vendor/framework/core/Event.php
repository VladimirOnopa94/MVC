<?php 

namespace framework\core;
use Exception;

/*
Класс события, полуает вызываемое собитые, переданые параметры (если есть),
назначает обработчики которые установлены в файле событий-обработчиков
*/ 
abstract class Event 
{
	private $eventsList;
	private $eventVariables;

    public function __construct(){

    	$this->eventsList = config('kernel.events'); //файл событий-обработчиков

    	$event = get_called_class();
    	$this->eventVariables = get_object_vars($this);//получим переменные из пользовательского события

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
					//удалим лишние переменные
					unset($this->eventVariables['eventsList']);
					unset($this->eventVariables['eventVariables']);
					//Создадим слушателя который назначен событию
					$listner = new $listenerClass();
					//Вызовем функцию handle слушаетля и передадим все аргументы переданые событию
					call_user_func_array(array($listner, 'handle'), $this->eventVariables);
	    		}else{
	    		 	throw new Exception("Listener class {$listenerClass}  not found " );
	    		}
			}catch (Exception $ex) {
				    echo $ex->getMessage();
			}
    	}
    }


}
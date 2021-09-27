<?php 

namespace framework\core;

/**
 *  Mail class
 */
class Mail 
{
	
	public $subject ;
	public $message ;
	public $to ;
	public $headers ;
	public $view ;
	public $data ;

	function __construct($subject, $message, $to, $headers = '', $view = '', $data = '')
	{	
		$this->subject = $subject;
		$this->message = $message;
		$this->to = $to;
		$this->headers = $headers;
		$this->view = $view;
		$this->data = $data;
	}

	//
	//Подключаем файл шаблона письма, передаем переменные 
	//

	public function init ()
	{

		if (isset($this->view) && !empty($this->view)) {

			if (isset($this->data)) { //Извлекаем переменные из контроллера 
				extract($this->data);
			}
				
			ob_start();

			$file_layout =  APP . '/views/' .$this->view . '.php';

			if (is_file($file_layout)){
				include $file_layout;
			}else{
				echo "Views " . $file_layout . " not found !";
			}
			$content = ob_get_contents();

			ob_end_clean();
		}else{
			$content = $this->message; 
		}


        if (is_array($this->to)) {
	        $mailTo = implode(', ', $this->to);	        
        }else{
        	$mailTo = $this->to;
        }
        
        mail($mailTo, $this->subject, $content, $this->headers);
		
	}
	

}
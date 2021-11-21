<?php 
namespace framework\core;
use Exception;

/**
 *  Класс отправки почты
 */
class Mail 
{
	
	public $subject ; /*Тема письма*/	
	public $message; /*Сообщение письма*/	
	public $to ; /*Адресат письма*/	
	public $headers = '' ; /*Заголовки письма*/	
	public $view; /*Шаблон письма*/	
	public $data ; /*Переменные письма*/	

	/**
	 * Установить заголовки
	 * @param  string $headers 
	 * @return object
	 */
	public function headers($headers)
	{
		$this->headers = $headers;
		return $this;
	}
	/**
	 * Установить тему письма
	 * @param  string $subject 
	 * @return object
	 */
	public function subject($subject)
	{
		$this->subject = $subject;
		return $this;
	}
	/**
	 * Установить получателя
	 * @param  string $to 
	 * @return object
	 */
	public function to($to)
	{
		$this->to = $to;
		return $this;
	}
	/**
	 * Установить сообщение письма
	 * @param  string $message 
	 * @return object
	 */
	public function text($message)
	{
		$this->message = $message;
		return $this;
	}
	/**
	 * Установить шаблон письма
	 * @param  string $view 
	 * @return object
	 */
	public function view($view)
	{
		$this->view = $view;
		return $this;
	}
	/**
	 * Установить переменные письма
	 * @param  string $data 
	 * @return object
	 */
	public function data($data)
	{
		$this->data = $data;
		return $this;
	}
	/**
	 * Отправить письмо
	 */
	public function send()
	{
		if (isset($this->view) && !empty($this->view)) {

			if (isset($this->data)) { //Извлекаем переменные из контроллера 
				extract($this->data);
			}
			
			ob_start();

			$template =  APP . '/views/' .$this->view . '.php';

			if (is_file($template)){
				include $template;
			}else{
				throw new Exception("View " . $template . " not found !");
			}
			
			$content = ob_get_clean ();

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



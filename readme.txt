*******АРХИТЕКТУРА ФРЕЙМВОРКА*******

app
	controllers
	models
	views
	language
		ru
		en
		ua
config
log
public
	css
	js
vendor
	composer
	framework
		core
		widgets
			views





********СМЕНА ШАБЛОНОВ В КОНТРОЛЛЕРАХ *******

В контроллерах есть возможность переопределять шаблон вида

объявив $this->layout 

public function index($request)
	{
		$this->layout = 'somelayout';

	}

Где somelayout шаблон somelayout.php который находиться в папке /app/views/layouts


-------------------------

В каждом методе контроллера доступна переменна $request 

которая содержит  параметры (somecat , product_1 , page ) запроса из URL (пример category/somecat/product_1?page=1)

public function index($request){

	$request->somecat // Доступ к свойствам 

}

------------------------------

********ВИДЖЕТЫ И ОТОБРАЖЕНИЕ ИХ В ВИДАХ*******

Создадим класс виджета в папке /app/widgets

Напирмер Footer.php и унаследовать класс \framework\core\Widget

Далее импортируем класс виджетов use framework\core\Widget;

Создадим  метод run где вернем данные пути к виду (обязательно) , и даные (не обязательно)

...
$data['footer_data'] = 'footer_data';
$data['view'] = 'widgets/footer';

return $data;

И в виде вызываем метод вывода виджета 

<?php app\widgets\Footer::widget(); ?>

----------------------------------------

*******************ЛОГИРОВАНИЕ******************* 

Для логирование сообщений вызываем в коде $this->logger->log('text' , 'success_register');

где "text" текст который нужно записать,

"success_register" - файлов для записи указываем в config.php в кностанте LOG_PARAM['logs']['name_log' => 'path_to_file_log',..]

----------------------------------------

*******************Локализация*******************

В контроллере вида или виджета вызываем метод 

$this->language('index');

где 'index' , название языкового файла в папке /app/language/{код языка}/index.php

В файле вида (view) вызываем __($key)

Где  $key имя ключа в языковом файле

<?php echo  __("title_sidebar") ?>

----

Переключение языков проиходит по url : 

language/{code}

где code - код выбраного языка

----------

Для формирования ссылок в видах используем функцию 

url('/someUrl') 

которая выводит ссылку сформированую с выбраным языком 

/someUrl будет преобразована в /{code}/someUrl

где {code} будет подставлен выбраный язык пользователя

----------
Ajax запросы нужно производить без указания в запросе метки языка 


$.ajax({
  url: "/page/some",
  data: {test:'test'},
  success: function(){
  }
});

в массиве роутов запишем с указанием метки языка {lang}

'{lang}/page/some' 	=> 'Site\IndexController@Page'


********************Валидация форм*******************

Используется библиотека respect-validation
DOCS https://respect-validation.readthedocs.io/en/latest/

Пример валидации 
if (isset($_POST)) {

	$credentials = array('email' => $_POST['email'] , 'password' => $_POST['password']);

	$validator = v::key('email', v::email()->notEmpty())
            	->key('password', v::length(6,null));
	try {
		$validator->assert($credentials);
		.....
		
	} catch(NestedValidationException $exception) {
	   print_r($exception->getMessages());
	}
	
}

********************Временные сообщения *******************

В любом месте приложение используем 

flashMassage('login', 'Успех'); 

что бы установить сообщение с ключем 'login' и текстом 'Успех'

в файле вида после установки можем использовать для отображения сообщения

<?php if ($messege = flashMessage('login')) { ?>
	<div class="alert alert-danger" role="alert">
	  <?php echo $messege; ?>
	</div>
<?php } ?>


******************** Title страницы *******************
Для указания заголовка страницы спользуем функцию $this->setTitle('Главная');
	public function Index()
	{
		$this->setTitle('Главная');
		
	}
	Для отображение в шаблоне 

	<title><?php echo $this->getTitle(); ?></title>


********************Пользовательские функции *******************

В файле  /vendor/framework/core/Functions.php
можно добавлять пользовательские функции, которые будут доступны в любой точке приложения 


********************Функция отправки писем *******************

$this->sendMail($subject, $message, $to, $headers, $view, $variables);

$subject (обязательный) - тема письма
$message (необязательный) - сообщение, если не указан шаблон письма передаем пустую строку
$to (обязательный) - получатели, массив получателей или один получатель строкой 'test@gmail.com'
$headers (необязательный) - заголовки, если нет заголовков передаем пустую строку
$view (необязательный) - шаблон, указываем путь к файлу php от папки views пример (mail/mail) значит что шаблон находится app/views/mail/mail.php, если не нужен передаем пустую строку
$variables (необязательный) - переменные, для передачи в шаблон письма , если нет передаем пустую строку

-------

Пример 

$var = 'Информация';

$headers = "Content-Type: text/html; charset=UTF-8\r\n";

$this->sendMail(
	'Тема фреймоврк', //тема письма  
	'', //Текст если не указан шаблон
	['test@gmail.com', 'test2@mail.ru'], //получатели письма
	$headers, //Заголовки письма
	'mail/mail', //шаблон письма 
	compact('var')	//Переменные в шаблон письма
);
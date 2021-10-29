*******АРХИТЕКТУРА ПРИЛОЖЕНИЯ*******

app
----controllers
----components
	----events
	----listeners
	----widgets
	--------views
	----middlewares
	--------views
----models
----views
----language
--------ru
--------en
--------ua
config
----routes
log
public
----css
----js
vendor
----composer
----framework
--------core
		


******** ВИДЫ *******


	В каждом виде можно подключать сколько угодно дополнительных видов 

	к приеру  файл views/index.php может иметь код 

	html code....

	<?php $this->render('parts/form'); ?>

	<?php $this->render('parts/form1', compact('var1')); ?>

	html code....

	в результате будут подключены виды form, form1 из каталогов /views/parts

	вид form1 будет иметь доступ к переменной $var1


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

	Так же в каждом контроллере можно получить доступ к методам и свойствам объявленых в главном контроллере 

	по пути app\controllers\Controller

	для этого объявим переменную

	public $cart; // это свойство будет доступно во всех контроллерах 

	public function __construct(){
	    $this->cart = 'somedata';   
	    
	    parent::__construct();
	}

------------------------------

********ВИДЖЕТЫ И ОТОБРАЖЕНИЕ ИХ В ВИДАХ*******

	Создадим класс виджета в папке /app/widgets

	Напирмер Footer.php и унаследовать класс \framework\core\Widget

	Далее используем класс виджетов use framework\core\Widget;

	Создадим  метод run где вернем данные пути к виду (обязательно) , и даные (не обязательно)

	...
	$data['footer_data'] = 'footer_data';
	$data['view'] = 'widgets/footer';

	return $data;

	И в виде вызываем метод вывода виджета 

	<?php app\components\widgets\Footer::widget(); ?>

	Можем передавать переменные в виджет  Footer::widget($var1, $var2);

	в методе виджета получим их 

	public  function run($var1, $var2) {}

	В виджетах доступен csrf токен, как и в контроллерах

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


********************Валидация данных*******************

	Доступные типы валидации

	max:10 - макс кол. символов
	min:2 -  мин кол. символов
	required -  поле обязательное
	date -  поле должно быть датой
	email - поле должно содержатьemail
	numeric - поле должно быть числом
	alphanumeriс - поле должно содержать только буквы или цифры
	alpha - поле должно содержать только буквы
	image - файл должен быть изображением
	mimes:xml,rar - файл должен содержать допустимые расширения

	-------
	Пример валидации 

		$credentials = array('name' => $_POST['name'] , 'password' => $_POST['password'], 'file' => $_POST['file']);

		VD::load($credentials);

		$errors = VD::validate([
			'name' => 'required|alpha' , 
			'password' => 'required|numeric|max:10|min:2' , 
			'file' => 'required|mimes:xml' , 
		]); 

	в переменную $errors записываются все ошибки
		

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


******************** Middlewares*******************

	Что бы использовать промежуточное ПО в файле контроллера объявляем конструктор ,
	и указываем нужный нам Middleware 

	$this->Middleware(new \app\components\middlewares\UserMiddleware(['Login']));

	Если Middleware нужно использовать на все методы контроллера, не передаем аргументы классу Middleware
	иначе, указываем нужный нам метод в массиве можно через запятую  ['Login' , 'Index']

	В конце обязательно вызываеам родительский конструктор parent::__construct();

	Пример

	public function __construct(){
		$this->Middleware(new \app\components\middlewares\UserMiddleware(['Login']));
		$this->Middleware(new \app\components\middlewares\RoleCheckMiddleware());
		parent::__construct();
	}


******************** Events *******************

	Что бы использовать события, для начала добавим их и слушателей listeners
	в файл конфигурации событий config\events.php

	return [
		'app\components\events\RegisterUserEvent' => [
			'app\components\listeners\RegisterListener',
			'....'
		],
		'....'
	];

	Создадим класс события app\components\events\RegisterUserEvent
	класс будет использовать конструктор вызывающий родительский конструктор,
	конструктор принимает переданые параметр(для обработки в listener)

	public $data;
	public $text;

	public function __construct($data,$text)
	{
		$this->data = $data;
		$this->text = $text;
		parent::__construct($this->data, $this->text);
	}

	Создадим класс слушателя app\components\listeners\RegisterListener
	классе нужно объявить метод handle который может принимать аргуметы с класа события(если переданы)

	public function handle ($data, $text){
		var_dump($text);
		var_dump($data);
		//тут делаем то что нужно после того как событие настало		
	}

	В конце используем созданое событие в коде 

	Импортируем класс
	use app\components\events\RegisterUserEvent; 

	И вызовем класс, и передадим аргументы если нужно
	new RegisterUserEvent($array,'text');

******************** Registry *******************

	Запишим данные доступные с любой точки приложения 

	\framework\core\Registry::set('cart', 'test');

	Получим данные 

	echo \framework\core\Registry::get('cart'); 
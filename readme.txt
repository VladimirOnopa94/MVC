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
tmp
----log
----cache
public
----css
----image
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

	Если нужно вернуть только html, а не отобразить страницу (например при AJAX запросе)

	Добавим третим параметром true

	echo $this->render('parts/form1', compact('var1'), true);
	die;


********СМЕНА ШАБЛОНОВ В КОНТРОЛЛЕРАХ *******

	В контроллерах есть возможность переопределять шаблон вида объявив для конткретного метода 

	public function index($request)
	{
		$this->layout = 'layout1';
	}

	или для всего контроллера 

	public $layout = 'layout1';

	Где somelayout шаблон layout1.php который находиться в папке /app/views/layouts


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

	Напирмер Footer.php и унаследуем класс \framework\core\Widget

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

	Для логирование сообщений вызываем в коде App::$app->logger->log('text', 'success_register');
											
	где "text" текст который нужно записать,

	"success_register" - файлов для записи указываем в config.php в кностанте LOG_PARAM['logs']['name_log' => 'path_to_file_log',..]

----------------------------------------

*******************Локализация*******************

	В контроллере вида или виджета вызываем метод 

	$this->language('index');

	где 'index' , название языкового файла в папке /app/language/{код языка}/index.php

	В файле вида (view) вызываем __($key, $data)

	Где $key (обязательно) имя ключа в языковом файле

	Где $data (необязательно) данные для подставления в строке, для замены

	<?php echo  __("title_sidebar", ['text' => 'innerText']) ?>

	В языковом файле 'title_sidebar' => 'Тут добавлен :text',

	----

	Переключение языков проиходит по url : 

	language/{code}

	где code - код выбраного языка

	----------

	Для формирования ссылок в видах используем функцию 

	url('/someUrl') ->> test.com/someUrl

	url('/someUrl', true) //для формирования без домена в url  ->> /someUrl 

	url('/someUrl', 'api_prefix') //для формирования префикса в url  ->> test.com/api_prefix/someUrl 

	url('/someUrl', getLang()) //для формирования языка в url  ->> test.com/en/someUrl 


	----------
	Ajax запросы нужно производить без указания в запросе метки языка 


	$.ajax({
	  url: "/page/some",
	  data: {test:'test'},
	  success: function(){
	  }
	});

******************** Роутинг *******************

Возможно использовать группы в которые можно (необязательно) передавать префикс и суффикс, которые можно добавить в url и к ссылкам

use framework\core\Route\Route;


Route::group(['suffix' => '', 'prefix' => '')], function(){ }); //без префикса и суфикса

Route::group(['suffix' => '.html', 'prefix' => getLang(true)], function(){ 

	Route::get('' 						, 'Site\IndexController@Index')->name('main');
	Route::get('/category/{category}/{post}' 	, 'Site\Auth\LoginController@TestPage')->name('category.product');
	Route::post('/signup' 				, 'Site\Auth\RegisterController@Signup');

});

будет сформирован роут с именем который указан в файле роутинга  и параметры подставлены в ссылку

route('category.product', ['category'= > 'cat', 'post' => 'test']) ->> test.com/category/cat/test


Либо использовать вне группы без префикса и суфикса

Route::get('contact', 'Site\IndexController@Index');

route('contact') ->> test.com/contact


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
	
		$errors = VD::load($credentials)->validate([
			'name' => 'required' , 
			'password' => 'required' , 
		]); 
			
		if (empty($errors)) {
			//do some
		}

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

	$subject (обязательный) - тема письма
	$text (необязательный) - сообщение
	$to (обязательный) - получатели, массив получателей или один получатель строкой 'test@gmail.com'
	$headers (необязательный) - заголовки
	$view (необязательный) - шаблон, указываем путь к файлу php от папки views пример (mail/mail) значит что шаблон находится app/views/mail/mail.php
	$data (необязательный) - переменные, для передачи в шаблон письма

	-------

	Пример 

	use framework\core\Mail;

	$var = 'Информация';

	$headers = "Content-Type: text/html; charset=UTF-8\r\n";

	$mail = new Mail();
	$mail->subject('Register')
		 ->to('wowaonopa1991@gmail.com')
		 ->view('mail/mail') 
		 ->text('some text') 
		 ->headers($headers)
		 ->data(compact('var'))
		 ->send();


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


******************** Пагинация  *******************


В контроллере передаем переменные для пагинации в вид

$page = App::$app->request->get('page', 1); //кол. страниц
$limit = 5; //елементов на странице

$users = new User; //выборка пользователей для пагинации
$users = $users->getUsers($page,$limit);

$total = (isset($users['total'])) ? count($users['total']) : [] ;
$users = (isset($users['result'])) ? $users['result'] : [] ;

$this->render('users_list' , compact('total', 'page', 'limit', 'users'));

--------

В виде  вызываем виджет пагинации

<?php 	if ($users) {
	app\components\widgets\PaginationW::widget($total, $page, $limit );
} ?>

---Виджет пагинации

use framework\core\Pagination;

public  function run($total, $page, $limit)
{
	
	$pagination = new Pagination($total, $page, $limit, '?page=');
	$result['pagination'] = $pagination->get();

	$result['view'] = 'pagination';

	return $result ; 
}


-----
Вид 

<?php echo $pagination; ?>


******************** Breadcrumbs  *******************

В шаблоне выведем хлебные крошки (layout/default.php) и установим Главную

<?php app\components\widgets\Breadcrumbs::widget(array('name' => 'Главная', 'href' => url('/'))); ?>


в контроллере или виде добавим елемент для хлебной крошки 

use app\components\widgets\Breadcrumbs;


Breadcrumbs::$param['breadcrumbs'][] = array('name' => __('login_title') );


В виджетах 

class Breadcrumbs extends Widget{ 

	public  function run($breadcrumbs)
	{
		if (isset($breadcrumbs) && !is_null(Widget::$param['breadcrumbs'])) {
			array_unshift(Widget::$param['breadcrumbs'], $breadcrumbs); 
		}

		if ($breadcrumbs = Widget::$param['breadcrumbs']) {
			$i = 0;
			$numItems = count($breadcrumbs);
			foreach ($breadcrumbs  as $key => $value) {
				$href = '';
				if (isset($value['href'])) {
					$href = $value['href'];
				}
				$result['breadcrumbs'][$key]['name'] = $value['name'];
				$result['breadcrumbs'][$key]['href'] = $href;
				if(++$i != $numItems) {
				    $result['breadcrumbs'][$key]['delimiter'] = '>';
				}  
		   } 
		}

		$result['view'] = 'breadcrumbs';

		return $result;
	}

-------------

в виде виджета 

<?php if (isset($breadcrumbs)) { ?>
	<div class="breadcrumbs">
		<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
			<?php if (isset($breadcrumb['href']) && !empty($breadcrumb['href'])) { ?>
				<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['name']; ?></a>
				<?php if (isset($breadcrumb['delimiter'])) { echo $breadcrumb['delimiter'];} ?>
			<?php }else{ ?>
				<span><?php echo $breadcrumb['name']; ?></span>
				<?php if (isset($breadcrumb['delimiter'])) { echo $breadcrumb['delimiter'];} ?>
			<?php } ?>
			
		<?php } ?>
	</div>
<?php } ?>

******************** Кеширование  *******************

use framework\core\App;

Запись:

App::$app->cache->set('test', ['data'=> 1, 'test' => '2'], 6000);

Записать в кеш по ключу "test", 
данные [data= > 'data'],
на 6000 секунд

Чтение:

App::$app->cache->get('test') получить содержимое кеша по ключу test



Пример:
 
if (!$data = App::$app->cache->get('test')) {
	$data = ['data'];
	App::$app->cache->set('test', $data, 6000);
}

******************** Изображения  *******************

Для загрзки изображений используем 

use framework\core\Image;

foreach ($_FILES as $key => $file) {

	$path = IMAGE; путь к папке сохранения
	$name = 'new_img' . microtime(); имя изображения (Если не указано, будет сохранен с исходным именем)
				
	Image::create($file)->encode("webp", 10)->size(500, 100)->save($path, $name);
}
size() - изменить размер изображения (опционально)
encode()-  изменить формат и качество изображения (опционально) (0-100 [0 худшее качество, 100 лучшее])

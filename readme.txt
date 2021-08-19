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

Напирмер Sidebar.php и унаследовать класс \framework\core\Widget

Далее импортируем класс виджетов use framework\core\Widget;

Создадим  метод run где вернем данные пути к виду (обязательно) , и даные (не обязательно)

$data['footer_data'] = 'footer_data';
$data['view'] = 'widgets/footer';

return $data;

И в конце вызываем в нужном месте метод вывода виджета 

<?php app\widgets\Footer::widget(); ?>

----------------------------------------

*******************ЛОГИРОВАНИЕ******************* 

Вызываем в коде $this->logger->log('text' , 'success_register');

где "text" текст который нужно записать,

"success_register" - файлов для записи указываем в config.php в кностанте LOG_PARAM['logs']['name_log' => 'path_to_file_log',..]

----------------------------------------

*******************Локализация*******************

В контроллере вида, виджета вызываем метод 

$this->language('index');

где index , название языкового файла в папке /app/language/{код языка}/index.php

В файле вида вызываем __($key)

Где  $key имя ключа в языковом файле

<?php echo  __("title_sidebar") ?>

----

Переключение языков проиходит по url : 

language/{code}

где code - код выбраного языка

---

Для формирования ссылок в видах используем функцию 

lLink('/someUrl') 

которая выводит ссылку сформированую с выбраным языком 

/someUrl будет преобразована в {code}/someUrl

где {code} будет подставлен выбраный язык пользователя





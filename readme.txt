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


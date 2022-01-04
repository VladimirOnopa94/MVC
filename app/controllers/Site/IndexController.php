<?php 
namespace app\controllers\Site;

use app\models\Auth\User;
use app\models\Category;
use app\controllers\Controller;
use framework\core\App;


class IndexController extends Controller{ 

	public $csrf = false; 

	public function index($request)
	{

		//if (!$data = App::$app->cache->get('test')) {

		//}

		/*$this->setMeta('keywords', 'somekeywords');
		$this->setMeta('og:url', 'some content', 'property');
		$this->setStyle(resource('/css/some.css'));
		$this->setScript(resource('/js/some.js'));*/

		$this->language('index');
		$this->setTitle('Главная');
		
		$this->render('index');
	}
	
	public function Api($request)
	{
		//if ($data = App::request()->post()) {

			//App::$app->logger->log(json_encode($data) , 'success_register');
		//}
	}
	public function ApiStat()
	{
		$this->render('index');
		/*$url = "https://mybigben.com.ua/api/token";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Accept: application/json",
		   "Host: mybigben.com.ua",
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = json_encode(array(
			"login" => "phantastika15@gmail.com",
	  		"password" => "7691!DF#s"
		));

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		$resp = json_decode($resp,true);

		if ($resp['success'] == true) {


			$url = "https://mybigben.com.ua/api/statistics";

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$headers = array(
			   "Accept: application/json",
			   "Host: mybigben.com.ua",
			   "Authorization: " . $resp['result']['token']
			);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			//for debug only!
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$stat = curl_exec($curl);
			curl_close($curl);
			var_dump($stat);
		}
		*/

	}
	public function Page($request)
	{
		echo "page";
	}

	public function Category($request)
	{
		$index = new Index();

		$categorys = $index->getCategory($request->id);
		
		$this->render('category/index' , compact('categorys'));

	}
	
}
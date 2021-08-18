<?php 

namespace app\controllers\Site;
use app\models\Index;


class LangController extends \framework\core\Controller{ 

	public function SetLang($request)
	{
		
		

		if (array_key_exists($request->code, LANG['langs']) ) {
			setcookie('lang' , $request->code, time() +3600*24*7, '/');
		}
		
		header("Location: " . $_SERVER['REDIRECT_HTTP_REFERER']);


	}


}
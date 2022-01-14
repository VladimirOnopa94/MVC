<?php 
namespace app\components\middlewares;
use framework\core\App;
use framework\core\Middleware;
use framework\core\Error\ErrorController;
use Exception;

class RoleCheckMiddleware extends Middleware
{
    public function execute()
    {
    	$user = Auth();

    	if ($user !== false) {

	        if (App::$app->user->checkRole('user', 1)) {
	           	return true;    
	        }else{

	        	$forbidden = new ErrorController;
	            $forbidden->ShowForbbiden();

	            return false;
	        }
        }
        return true;
    }
}
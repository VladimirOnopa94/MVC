<?php 
namespace app\components\middlewares;
use framework\core\Middleware;
use DateTime;

class LoginAttemptsMiddleware extends Middleware
{
    public function execute()
    {
    	if (isset($_SESSION['login_allow_attempt_time'])) {
    		$now = new DateTime(date("Y-m-d H:i:s"));
    		$next = new DateTime($_SESSION['login_allow_attempt_time']);

    		if ($now >= $next) {
    			unset($_SESSION['login_allow_attempt_time']);
    			unset($_SESSION['loginAttemptCount']);
    		}
    	}

    	if (isset($_SESSION['loginAttemptCount'])){
		   $_SESSION['loginAttemptCount']++;

		   if ($_SESSION['loginAttemptCount'] > 3){
		   	$_SESSION['login_allow_attempt_time'] = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s'))));

		    flashMessage('error', 'Превышен лимит попыток входа попробуйте через 5 минут!');
		    redirectBack();
		    
		    return false;
		   }
		}
		return true;

    }
}
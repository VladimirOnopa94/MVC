<?php 
namespace app\components\middlewares;
use framework\core\Middleware;

class UserMiddleware extends Middleware
{

    public function execute()
    {
        if (true) {
            die('UserMiddleware');
        }
    }
}
<?php 
namespace app\models;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
 */
class Country extends \framework\core\Model
{
	public $table = 'countries';
      
      /*
            get list countries
      */
	public function getCountries(){

            return $this->findAll();
	}

	

}
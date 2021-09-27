<?php 
namespace app\models;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
 */
class Category extends \framework\core\Model
{
	public $table = 'category';

	public function getCategories(){

		return DB::table($this->table)
            ->select('*')  
            ->where('category_info.lang', '=', getLang())  
            ->join('category_info', 'category_info.category_id', '=', $this->table.'.category_id')    
            ->get()
            ->toArray();
	}

	public function getCategory($url){

		return DB::table($this->table)
            ->select('*')  
            ->where('category_info.lang', '=', getLang())  
             ->where($this->table.'.url', '=', $url)
            ->join('category_info', 'category_info.category_id', '=', $this->table.'.category_id')    
            ->first();
            //->toArray();
	}

}
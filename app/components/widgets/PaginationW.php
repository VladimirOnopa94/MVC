<?php 

namespace app\components\widgets;
use framework\core\Widget;
use framework\core\Pagination;

class PaginationW extends Widget{ 

	public  function run($total, $page, $limit)
	{
		
		$pagination = new Pagination($total, $page, $limit, '?page=');
		$result['pagination'] = $pagination->get();

		$result['view'] = 'pagination';

		return $result ; 
	}


	
}
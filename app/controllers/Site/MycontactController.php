<?php 
namespace app\controllers\Site;

use app\models\Auth\User;
use app\models\Country;
use app\controllers\Controller;

class MycontactController extends Controller{ 

	/*
		Update user info
	*/
	public function store($request){
		
		if (!empty($request) && $currentUser = Auth()) {
			$userObj = new User;
			$userObj->saveUserInformation($currentUser['user_id'],$request);
		}
	}

	/*
		Load user info
	*/
	public function index(){
		$page = "My Contact";

		$currentUser = Auth();

		$userObj = new User;
		$countriesObj = new Country;

		$users = $userObj->getUsersInformation();
		$countries = $countriesObj->getCountries();
		
		$contacts = array();

		foreach ($users as $key => $user) {

			$contacts['id'] = $user->id;
			$contacts['name'] = $user->name;
			$contacts['lastname'] = $user->lastname;
			$contacts['address'] = $user->address;
			$contacts['city'] = $user->city;
			$contacts['country'] = $user->cid;
			$contacts['publish_contact'] = $user->publish_contact;
			$contacts['phones'] = $userObj->getUserPhones($currentUser['user_id'], ['1','0']);
			$contacts['emails'] = $userObj->getUserEmails($currentUser['user_id'], ['1','0']);

			$data['page'] = $page;
			$data['data'] = $contacts;
			$data['countries'] = $countries;

			echo json_encode($data);
			exit;
		}	

	}


	
	
}
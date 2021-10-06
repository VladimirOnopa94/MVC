<?php 
namespace app\controllers\Site;

use app\models\Auth\User;
use framework\core\Controller;

class PhonebookController extends Controller{ 

	public function index()
	{
		$userObj = new User;
		$page = "Phonebook";

		$users = $userObj->getUsersInformation();
		$contacts = array();

		foreach ($users as $key => $user) {

			/*if hide phone, replace all charters to **/
			$phones = array();
			foreach ($userObj->getUserPhones($user->id, ['1']) as $key => $curr_phone) {
				if ($curr_phone->is_show == '0') {
					$phones[] = preg_replace("/\d/", "X", $curr_phone->phone);
				}else{
					$phones[] = $curr_phone->phone; 
				}
			}
			/*if hide email, replace all charters to **/
			$emails = array();
			foreach ($userObj->getUserEmails($user->id, ['1']) as $key => $curr_email) {
				if ($curr_email->is_show == '0') {
					$emails[] = str_repeat("X", strlen($curr_email->email)); 
				}else{
					$emails[] = $curr_email->email; 
				}
			}

			$contacts[$user->id]['id'] = $user->id;
			$contacts[$user->id]['name'] = $user->name;
			$contacts[$user->id]['address'] = $user->address;
			$contacts[$user->id]['city'] = $user->city;
			$contacts[$user->id]['country'] = $user->country;
			$contacts[$user->id]['phones'] = $phones;
			$contacts[$user->id]['emails'] = $emails;
		}	

		$data['page'] = $page;
		$data['data'] = $contacts;

		echo json_encode($data);
		exit;
	}


	
	
}
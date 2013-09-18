<?php
class SessionsController extends AppController {
	public $helpers = array('Html');


	public function create() {

	}

	public function fb_login() {
		if (!array_key_exists("code", $this->request->query)) {
			if (array_key_exists("error_description", $this->request->query)) {
				$this->set('fb_error', $this->request->query['error_description']);
			}
			return;
		}
		App::uses('HttpSocket', 'Network/Http');
		$fb_code = $this->request->query["code"];
		$http_socket = new HttpSocket();
		$fb_access_token_response = explode('&', $http_socket->get('https://graph.facebook.com/oauth/access_token', array(
				'client_id' => Configure::Read('FB_API'),
				'client_secret' => Configure::Read('FB_SECRET'),
				'code' => $fb_code,
				'redirect_uri' => Router::url(array('controller' => 'sessions', 'action' => 'fb_login'), true)
			)));
		$access_token = false;
		foreach($fb_access_token_response as $response) {
			if (urldecode((explode('=', $response)[0]) == 'access_token')) {
				$access_token = urldecode(explode('=', $response)[1]);
			}
		}
		// TODO Properly handle the case where access_token is not found.
		if ($access_token === false) {
			return false;
		}
		$fb_get_email_address_request = 'https://graph.facebook.com/fql?q=SELECT+email+FROM+user+WHERE+uid=me()&access_token='.$access_token;
		// error_log($fb_get_email_address_request);
		$fb_email_address_response = json_decode($http_socket->get($fb_get_email_address_request), true);
		// TODO Properly handle the case where email is not found
		if (array_key_exists("data", $fb_email_address_response) && array_key_exists("email", $fb_email_address_response["data"][0])) {
			$email = $fb_email_address_response["data"][0]["email"];
		} else {
			return;
		}
	}
}
?>

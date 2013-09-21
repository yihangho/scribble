<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class FacebookAuthComponent extends Component {
	public function get_access_token($code) {
		$http_socket = new HttpSocket();
		$fb_access_token_response = explode('&', $http_socket->get('https://graph.facebook.com/oauth/access_token', array(
				'client_id' => Configure::Read('FB_API'),
				'client_secret' => Configure::Read('FB_SECRET'),
				'code' => $code,
				'redirect_uri' => Router::url(array('controller' => 'sessions', 'action' => 'fb_login'), true)
			)));
		$access_token = false;
		foreach($fb_access_token_response as $response) {
			if (urldecode((explode('=', $response)[0]) == 'access_token')) {
				$access_token = urldecode(explode('=', $response)[1]);
			}
		}
		return $access_token;
	}

	public function get_email_address($access_token) {
		$http_socket = new HttpSocket();
		$fb_get_email_address_request = 'https://graph.facebook.com/fql?q=SELECT+email+FROM+user+WHERE+uid=me()&access_token='.$access_token;
		$fb_email_address_response = json_decode($http_socket->get($fb_get_email_address_request), true);
		if (array_key_exists("data", $fb_email_address_response) && array_key_exists("email", $fb_email_address_response["data"][0])) {
			return $fb_email_address_response["data"][0]["email"];
		} else {
			return false;
		}
	}
}
?>

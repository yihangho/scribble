<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class GoogleAuthComponent extends Component {
	public function get_access_token($code) {
		$http_socket = new HttpSocket();
		$google_access_token_response = $http_socket->post('https://accounts.google.com/o/oauth2/token', array(
				'client_id' => Configure::Read('GOOGLE_API'),
				'client_secret' => Configure::Read('GOOGLE_SECRET'),
				'code' => $code,
				'redirect_uri' => Router::url(array('controller' => 'sessions', 'action' => 'google_plus_login'), true),
				'grant_type' => 'authorization_code'
			));
		$google_access_token_response = json_decode($google_access_token_response->body, true);
		if (array_key_exists("access_token", $google_access_token_response)) {
			return $google_access_token_response["access_token"];
		} else {
			return false;
		}
	}

	public function get_email_address($access_token) {
		$http_socket = new HttpSocket();
		$google_email_address_response = $http_socket->get('https://www.googleapis.com/oauth2/v2/userinfo', array(
			'access_token' => $access_token
			));
		$google_email_address_response = json_decode($google_email_address_response->body, true);
		if (array_key_exists("email", $google_email_address_response)) {
			return $google_email_address_response["email"];
		} else {
			return false;
		}
	}
}
?>

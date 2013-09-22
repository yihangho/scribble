<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class GoogleAuthComponent extends Component {

	public function getAccessToken($code) {
		$httpSocket = new HttpSocket();
		$googleAccessTokenResponse = $httpSocket->post('https://accounts.google.com/o/oauth2/token', array(
				'client_id' => Configure::Read('GOOGLE_API'),
				'client_secret' => Configure::Read('GOOGLE_SECRET'),
				'code' => $code,
				'redirect_uri' => Router::url(array('controller' => 'sessions', 'action' => 'google_plus_login'), true),
				'grant_type' => 'authorization_code'
			));
		$googleAccessTokenResponse = json_decode($googleAccessTokenResponse->body, true);
		if (array_key_exists("access_token", $googleAccessTokenResponse)) {
			return $googleAccessTokenResponse["access_token"];
		} else {
			return false;
		}
	}

	public function getEmailAddress($accessToken) {
		$httpSocket = new HttpSocket();
		$googleEmailAddressResponse = $httpSocket->get('https://www.googleapis.com/oauth2/v2/userinfo', array(
			'access_token' => $accessToken
			));
		$googleEmailAddressResponse = json_decode($googleEmailAddressResponse->body, true);
		if (array_key_exists("email", $googleEmailAddressResponse)) {
			return $googleEmailAddressResponse["email"];
		} else {
			return false;
		}
	}
}

<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class FacebookAuthComponent extends Component {

	public function getAccessToken($code) {
		$httpSocket = new HttpSocket();
		$fbAccessTokenResponse = $httpSocket->get('https://graph.facebook.com/oauth/access_token', array(
				'client_id' => Configure::Read('FB_API'),
				'client_secret' => Configure::Read('FB_SECRET'),
				'code' => $code,
				'redirect_uri' => Router::url(array('controller' => 'sessions', 'action' => 'fbLogin'), true)
			))->body;
		$entries = explode('&', $fbAccessTokenResponse);
		$accessToken = false;
		foreach ($entries as $entry) {
			if (urldecode(explode('=', $entry)[0]) == 'access_token') {
				$accessToken = urldecode(explode('=', $entry)[1]);
			}
		}
		return $accessToken;
	}

	public function getEmailAddress($accessToken) {
		$httpSocket = new HttpSocket();
		$fbGetEmailAddressRequest = 'https://graph.facebook.com/fql?q=SELECT+email+FROM+user+WHERE+uid=me()&access_token=' . $accessToken;
		$fbEmailAddressResponse = json_decode($httpSocket->get($fbGetEmailAddressRequest), true);
		if (array_key_exists("data", $fbEmailAddressResponse) && array_key_exists("email", $fbEmailAddressResponse["data"][0])) {
			return $fbEmailAddressResponse["data"][0]["email"];
		} else {
			return false;
		}
	}
}

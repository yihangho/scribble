<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class TwitterAuthComponent extends Component {
	public $components = array('Session');
	public function get_oauth_token() {
		$this->Session->delete('twitterOAuthToken');
		$this->Session->delete('twitterOAuthTokenSecret');
		$authorization_string = $this->_authorizationString('POST', 'https://api.twitter.com/oauth/request_token', '', array(
			'oauth_callback' => Router::url(array('controller' => 'sessions', 'action' => 'twitter_login'), true)
			));
		$http_socket = new HttpSocket();
		$twitter_oauth_token_response = $http_socket->post('https://api.twitter.com/oauth/request_token', array(), array(
			'header' => array(
				'Authorization' => $authorization_string
				)
			))->body;
		$data_set = explode('&', $twitter_oauth_token_response);
		$oauth_token = $oauth_token_secret = false;
		foreach($data_set as $entry) {
			$entry = explode('=', $entry);
			if ($entry[0] == 'oauth_token') {
				$oauth_token = $entry[1];
			} else if ($entry[0] == 'oauth_token_secret') {
				$oauth_token_secret = $entry[1];
			} else if ($entry[0] == 'oauth_verifier') {
				$oauth_verifier = $entry[1];
			}
		}
		// TODO Handle error
		$this->Session->write('twitterOAuthToken', $oauth_token);
		$this->Session->write('twitterOAuthTokenSecret', $oauth_token_secret);
		return $oauth_token;
	}

	public function get_access_token($_oauth_token, $_oauth_verifier) {
		// TODO Verify that oauth token matches
		$oauth_token = $this->Session->read('twitterOAuthToken');
		$oauth_token_secret = $this->Session->read('twitterOAuthTokenSecret');
		$oauth_verifier = $_oauth_verifier;
		$this->Session->write('twitterOAuthVerifier', $oauth_verifier);
		$authorization_string = $this->_authorizationString('POST', 'https://api.twitter.com/oauth/access_token', '', array(
			'oauth_token' => $oauth_token
			), array(
			'oauth_verifier' => $oauth_verifier
			));
		// $http_socket = new HttpSocket();

	}

	protected function _authorizationString($http_method, $url, $oauth_token_secret = '', $oauth_parameters = array(), $parameters = array()) {
		// $http_method should be either 'post' or 'get', case insensitive
		// $url is the URL that the request will be GET from or POSTed to
		// $parameters are the GET or POST parameters, combined into one array
		// $oauth_parameters is an array of key/value pair that will be part of the authorization string
		// $oauth_parameters will overwrite any value that also exists in $default_oauth_parameters

		// oauth_token is not included in $default_oauth_parameters because
		// 1. oauth_token changes all the time
		// 2. certain time, oauth_token does not exist, eg, when requesting for oauth_token
		$default_oauth_parameters = array(
			'oauth_consumer_key' => Configure::Read('TWITTER_API'),
			'oauth_nonce' => $this->_generateNonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
			);
		$oauth_parameters = array_merge($default_oauth_parameters, $oauth_parameters);


		$oauth_parameters['oauth_signature'] = $this->_getSignature($http_method, $url, $oauth_token_secret, $oauth_parameters, $parameters);
		// ksort($oauth_parameters, SORT_STRING);
		$authorization_string = 'OAuth ';
		$number_of_oauth_parameters = count($oauth_parameters);
		foreach($oauth_parameters as $key => $value) {
			$authorization_string .= rawurlencode($key).'="'.rawurlencode($value).'"';
			$number_of_oauth_parameters--;
			if ($number_of_oauth_parameters > 0) {
				$authorization_string .= ', ';
			}
		}
		return $authorization_string;
	}

	protected function _generateNonce() {
		// TODO Consider moving this function somewhere else that is more suitable
		// For example, a general cryptographic component
		$_nonce = base64_encode(openssl_random_pseudo_bytes(32));
		$nonce = preg_replace('/[^A-Za-z0-9]/', '', $_nonce);
		return $nonce;
	}

	protected function _getSignature($http_method, $url, $oauth_token_secret, $oauth_parameters, $parameters = array()) {
		// Helper function to generate oauth_signature
		$encoded_parameters = array();
		foreach($parameters as $key => $value) {
			$encoded_parameters[rawurlencode($key)] = rawurlencode($value);
		}
		foreach($oauth_parameters as $key => $value) {
			$encoded_parameters[rawurlencode($key)] = rawurlencode($value);
		}
		ksort($encoded_parameters, SORT_STRING);

		$parameter_string = "";
		$number_of_parameters = count($encoded_parameters);
		foreach($encoded_parameters as $key => $value) {
			$parameter_string .= "$key=$value";
			$number_of_parameters--;
			if ($number_of_parameters > 0) {
				$parameter_string .= '&';
			}
		}
		$signature_base_string = strtoupper($http_method).'&'.rawurlencode($url).'&'.rawurlencode($parameter_string);
		$signing_key = rawurlencode(Configure::Read('TWITTER_SECRET')).'&'.rawurlencode($oauth_token_secret);
		$signature = base64_encode(hash_hmac('sha1', $signature_base_string, $signing_key, true));
		return $signature;
	}
}
?>

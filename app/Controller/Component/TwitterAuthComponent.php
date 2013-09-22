<?php
App::Uses('Component', 'Controller');
App::Uses('HttpSocket', 'Network/Http');
class TwitterAuthComponent extends Component {

	public $components = array('Session');

	public function getOauthToken() {
		$this->Session->delete('twitterOAuthToken');
		$this->Session->delete('twitterOAuthTokenSecret');
		$authorizationString = $this->_authorizationString('POST', 'https://api.twitter.com/oauth/request_token', '', array(
			'oauth_callback' => Router::url(array('controller' => 'sessions', 'action' => 'twitterLogin'), true)
			));
		$httpSocket = new HttpSocket();
		$twitterOauthTokenResponse = $httpSocket->post('https://api.twitter.com/oauth/request_token', array(), array(
			'header' => array(
				'Authorization' => $authorizationString
				)
			))->body;
		$dataSet = explode('&', $twitterOauthTokenResponse);
		$oauthToken = $oauthTokenSecret = false;
		foreach ($dataSet as $entry) {
			$entry = explode('=', $entry);
			if ($entry[0] == 'oauth_token') {
				$oauthToken = $entry[1];
			} elseif ($entry[0] == 'oauth_token_secret') {
				$oauthTokenSecret = $entry[1];
			} elseif ($entry[0] == 'oauth_verifier') {
				$oauthVerifier = $entry[1];
			}
		}
		// TODO Handle error
		$this->Session->write('twitterOAuthToken', $oauthToken);
		$this->Session->write('twitterOAuthTokenSecret', $oauthTokenSecret);
		return $oauthToken;
	}

	public function getAccessToken($oauthToken, $oauthVerifier) {
		if ($oauthToken != $this->Session->read('twitterOAuthToken')) {
			return false;
		}
		$this->Session->write('twitterOAuthVerifier', $oauthVerifier);
		$authorizationString = $this->_authorizationString('POST', 'https://api.twitter.com/oauth/access_token', '', array(
			'oauth_token' => $oauthToken
			), array(
			'oauth_verifier' => $oauthVerifier
			));
	}

	protected function _authorizationString($httpMethod, $url, $oauthTokenSecret = '', $oauthParameters = array(), $parameters = array()) {
		// $http_method should be either 'post' or 'get', case insensitive
		// $url is the URL that the request will be GET from or POSTed to
		// $parameters are the GET or POST parameters, combined into one array
		// $oauth_parameters is an array of key/value pair that will be part of the authorization string
		// $oauth_parameters will overwrite any value that also exists in $default_oauth_parameters

		// oauth_token is not included in $default_oauth_parameters because
		// 1. oauth_token changes all the time
		// 2. certain time, oauth_token does not exist, eg, when requesting for oauth_token
		$defaultOauthParameters = array(
			'oauth_consumer_key' => Configure::Read('TWITTER_API'),
			'oauth_nonce' => $this->_generateNonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
			);
		$oauthParameters = array_merge($defaultOauthParameters, $oauthParameters);

		$oauthParameters['oauth_signature'] = $this->_getSignature($httpMethod, $url, $oauthTokenSecret, $oauthParameters, $parameters);
		$authorizationString = 'OAuth ';
		$numberOfOauthParameters = count($oauthParameters);
		foreach ($oauthParameters as $key => $value) {
			$authorizationString .= rawurlencode($key) . '="' . rawurlencode($value) . '"';
			$numberOfOauthParameters--;
			if ($numberOfOauthParameters > 0) {
				$authorizationString .= ', ';
			}
		}
		return $authorizationString;
	}

	protected function _generateNonce() {
		// TODO Consider moving this function somewhere else that is more suitable
		// For example, a general cryptographic component
		$_nonce = base64_encode(openssl_random_pseudo_bytes(32));
		$nonce = preg_replace('/[^A-Za-z0-9]/', '', $_nonce);
		return $nonce;
	}

	protected function _getSignature($httpMethod, $url, $oauthTokenSecret, $oauthParameters, $parameters = array()) {
		// Helper function to generate oauth_signature
		$encodedParameters = array();
		foreach ($parameters as $key => $value) {
			$encodedParameters[rawurlencode($key)] = rawurlencode($value);
		}
		foreach ($oauthParameters as $key => $value) {
			$encodedParameters[rawurlencode($key)] = rawurlencode($value);
		}
		ksort($encodedParameters, SORT_STRING);

		$parameterString = "";
		$numberOfParameters = count($encodedParameters);
		foreach ($encodedParameters as $key => $value) {
			$parameterString .= "$key=$value";
			$numberOfParameters--;
			if ($numberOfParameters > 0) {
				$parameterString .= '&';
			}
		}
		$signatureBaseString = strtoupper($httpMethod) . '&' . rawurlencode($url) . '&' . rawurlencode($parameterString);
		$signingKey = rawurlencode(Configure::Read('TWITTER_SECRET')) . '&' . rawurlencode($oauthTokenSecret);
		$signature = base64_encode(hash_hmac('sha1', $signatureBaseString, $signingKey, true));
		return $signature;
	}
}

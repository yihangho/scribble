<?php
class SessionsController extends AppController {

	public $uses = array('User');

	public $components = array('FacebookAuth', 'GoogleAuth', 'Cookie');

	public function create() {
	}

	public function fbLogin() {
		if (!array_key_exists("code", $this->request->query)) {
			if (array_key_exists("error_description", $this->request->query)) {
				$this->set('fbError', $this->request->query['error_description']);
			}
			return;
		}

		$accessToken = $this->FacebookAuth->getAccessToken($this->request->query["code"]);
		// TODO Properly handle the case where access_token is not found.
		if ($accessToken === false) {
			return;
		}

		$email = $this->FacebookAuth->getEmailAddress($accessToken);
		// TODO Properly handle the case where email is not found
		if ($email === false) {
			return;
		}

		$currentUser = $this->User->force_get($email);

		$this->_logIn($currentUser);
	}

	public function googlePlusLogin() {
		if (!array_key_exists("code", $this->request->query)) {
			return;
		}

		$accessToken = $this->GoogleAuth->getAccessToken($this->request->query('code'));
		if ($accessToken === false) {
			return;
		}

		$email = $this->GoogleAuth->getEmailAddress($accessToken);
		if ($email === false) {
			return;
		}

		$currentUser = $this->User->force_get($email);

		$this->_logIn($currentUser);
	}

	protected function _logIn($user) {
		// Log user described by $user in

		//Get a new remember_token
		$rememberToken = $this->User->new_remember_token($user["User"]["id"]);

		// Set the new remember_token to cookie
		$this->Cookie->write('remember_token', $rememberToken, true, '20 years');

		//Set current user
		$this->currentUser = $user;
		$this->set('loggedIn', true);
		error_log("Logged in: " . $user["User"]["email"]);
	}
}

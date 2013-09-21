<?php
class SessionsController extends AppController {
	public $uses = array('User');
	public $components = array('FacebookAuth', 'GoogleAuth', 'Cookie');

	public function create() {

	}

	public function fb_login() {
		if (!array_key_exists("code", $this->request->query)) {
			if (array_key_exists("error_description", $this->request->query)) {
				$this->set('fb_error', $this->request->query['error_description']);
			}
			return;
		}

		$access_token = $this->FacebookAuth->get_access_token($this->request->query["code"]);
		// TODO Properly handle the case where access_token is not found.
		if ($access_token === false) {
			return;
		}

		$email = $this->FacebookAuth->get_email_address($access_token);
		// TODO Properly handle the case where email is not found
		if ($email === false) {
			return;
		}

		$current_user = $this->User->force_get($email);

		$this->log_in($current_user);
	}

	public function google_plus_login() {
		if (!array_key_exists("code", $this->request->query)) {
			return;
		}

		$access_token = $this->GoogleAuth->get_access_token($this->request->query('code'));
		if ($access_token === false) {
			return;
		}

		$email = $this->GoogleAuth->get_email_address($access_token);
		if ($email === false) {
			return;
		}

		$current_user = $this->User->force_get($email);

		$this->log_in($current_user);
	}

	private function log_in($user) {
		// Log user described by $user in

		//Get a new remember_token
		$remember_token = $this->User->new_remember_token($user["User"]["id"]);

		// Set the new remember_token to cookie
		$this->Cookie->write('remember_token', $remember_token, true, '20 years');

		//Set current user
		$this->currentUser = $user;
		$this->set('loggedIn', true);
	}
}
?>

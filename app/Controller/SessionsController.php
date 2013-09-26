<?php
class SessionsController extends AppController {

	public $uses = array('User');

	public $components = array('FacebookAuth', 'GoogleAuth', 'Cookie');

	public function create() {
		if ($this->currentUser) {
			return $this->redirect(Router::url(array('controller' => 'Users', 'action' => 'listScribbles')));
		}
		$this->set('loginPage', true);
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

		$currentUser = $this->User->forceGet($email);

		$this->_logIn($currentUser);

		return $this->redirect(Router::url(array('controller' => 'Scribbles', 'action' => 'add')));
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

		$currentUser = $this->User->forceGet($email);

		$this->_logIn($currentUser);

		return $this->redirect(Router::url(array('controller' => 'Scribbles', 'action' => 'add')));
	}

	public function destroy() {
		$this->Cookie->delete('remember_token');
		$this->currentUser = false;
		$this->set('loggedIn', false);
		$this->redirect(Router::url(array('controller' => 'sessions', 'action' => 'create')));
	}

	protected function _logIn($user) {
		// Log user described by $user in

		//Get a new remember_token
		$rememberToken = $this->User->newRememberToken($user["User"]["id"]);

		// Set the new remember_token to cookie
		$this->Cookie->write('remember_token', $rememberToken, true, '20 years');

		//Set current user
		$this->currentUser = $user;
		$this->set('loggedIn', true);
	}
}

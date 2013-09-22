<?php
class User extends AppModel {

	public function forceGet($email) {
		// Get the user with $email. Create user if not exist.
		$user = $this->find('first', array('conditions' => array(
			'User.email' => $email
			)));
		if (!$user) {
			$this->create();
			$user = $this->save(array('User' => array(
				'email' => $email
				)));
		}
		return $user;
	}

	public function newRememberToken($id) {
		// Generate, set and return a new remember_token for row with id = $id
		$userExists = $this->find('count', array('conditions' => array(
			'User.id' => $id
			)));
		if (!$userExists) {
			return false;
		}
		$rememberToken = sha1(mt_rand() . '' . mt_rand());
		$this->id = $id;
		$this->set('remember_token', $rememberToken);
		$this->save();
		return $rememberToken;
	}
}

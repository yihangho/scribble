<?php
class User extends AppModel {
	public function force_get($email) {
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

	public function new_remember_token($id) {
		// Generate, set and return a new remember_token for row with id = $id
		$user_exists = $this->find('count', array('conditions' => array(
			'User.id' => $id
			)));
		if (!$user_exists) {
			return false;
		}
		$remember_token = sha1(mt_rand().''.mt_rand());
		$this->id = $id;
		$this->set('remember_token', $remember_token);
		$this->save();
		return $remember_token;
	}
}
?>

<?php
class UsersController extends AppController {

	public function listScribbles() {
		if (!$this->currentUser) {
			return $this->redirect(Router::url(array('controller' => 'Scribbles', 'action' => 'add')));
		}
		$this->set('currentUser', $this->currentUser);
	}
}

<?php
class UsersController extends AppController {

	public $components = array('Paginator');

	public $helpers = array('Form', 'Html', 'Paginator');

	public $paginate = array(
		'limit' => 30
		);

	public function listScribbles() {
		if (!$this->currentUser) {
			return $this->redirect(Router::url(array('controller' => 'Scribbles', 'action' => 'add')));
		}
		$this->Paginator->settings = $this->paginate;
		$data = $this->Paginator->paginate($this->User->Scribble, array(
			'Scribble.user_id' => $this->currentUser['User']['id']
			));
		$this->set('data', $data);
		$this->set('showPagination', count($this->currentUser['Scribble']) > $this->paginate['limit']);
		$this->set('minePage', true);
	}
}

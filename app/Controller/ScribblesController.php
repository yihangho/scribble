<?php
App::uses('AppController', 'Controller');
class ScribblesController extends AppController {

	public $helpers = array('Html', 'Form', 'Js' => array('Jquery'));

	public $components = array('RequestHandler', 'Session');

	public function add() {
		$this->set("title_for_layout", "New Scribble");
		if ($this->request->is("post")) {
			$this->Scribble->create();
			if ($this->currentUser) {
				$this->request->data['Scribble']['user_id'] = $this->currentUser['User']['id'];
			}
			$newScribble = $this->Scribble->save($this->request->data, array("title", "body"));
			if ($newScribble) {
				$this->Session->setFlash("Scribble created!", "default", array("class" => "alert alert-success"));
				return $this->redirect(array("controller" => "Scribbles", "action" => "view", $newScribble["Scribble"]["ukey"]));
			} else {
				$this->Session->setFlash("Scribble cannot be created. :(", "default", array("class" => "alert alert-danger"));
			}
		}
	}

/**
 * @throws NotFoundException if ukey provided does not correspond to any Scribble
 */

	public function view($ukey = null) {
		$jsonRequest = $this->_isJsonRequest();

		$scribble = $this->Scribble->find("first", array(
			"conditions" => array("Scribble.ukey" => $ukey)
			));

		if (!$scribble) {
			throw new NotFoundException("Scribble not available");
		}

		if ($this->request->is("post") || $this->request->is("put")) {
			$this->Scribble->id = $scribble["Scribble"]["id"];
			if ($scribble["Scribble"]["read_only"] || $this->Scribble->save($this->request->data, array("fieldList" => array("title", "body")))) {
				if ($jsonRequest) {
					$this->set("status", "OK");
				} else {
					$this->Session->setFlash("Scribble updated", "default", array("class" => "alert alert-success"));
				}
			} else {
				if ($jsonRequest) {
					$this->set("status", "Error");
				} else {
					$this->Session->setFlash("Scribble cannot be updated", "default", array("class" => "alert alert-danger"));
				}
			}
		}

		//Current Scribble is loaded again as some data (like ukey and title) can be modified by the beforeSave hook
		$this->request->data = $scribble = $this->Scribble->find("first", array(
			"conditions" => array("Scribble.ukey" => $ukey)
			));

		$this->set("title_for_layout", $scribble["Scribble"]["title"]);

		$this->set("scribble", $scribble);

		if ($jsonRequest) {
			if ($this->request->is("post") || $this->request->is("put")) {
				$this->set("_serialize", array("status", "scribble"));
			} else {
				$this->set("message", "JSON not allowed");
				$this->set("_serialize", array("message"));
			}
		}
	}

	//Check if current request ask for a JSON response

	protected function _isJsonRequest() {
		return !!preg_match('/\/.*\.json/', $this->here);
	}
}

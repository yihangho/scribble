<?php
class ScribblesController extends AppController {
	public $helpers = array('Html', 'Form');

	public function add() {
		if ($this->request->is("post")) {
			$this->Scribble->create();
			if (($new_scribble = $this->Scribble->save($this->request->data, array("title", "body")))) {
				$this->Session->setFlash("Scribble created!");
				return $this->redirect(array("controller" => "Scribbles", "action" => "view", $new_scribble["Scribble"]["ukey"]));
			} else {
				$this->Session->setFlash("Scribble cannot be created. :(");
			}
		}
	}

	public function view($ukey = null) {
		if (!$ukey) {
			throw new NotFoundException("Scribble not available");
		}

		$scribble = $this->Scribble->find("first", array(
			"conditions" => array("Scribble.ukey" => $ukey)
			));

		if (!$scribble) {
			throw new NotFoundException("Scribble not available");
		}

		if ($this->request->is("post") || $this->request->is("put")) {
			$this->Scribble->id = $scribble["Scribble"]["id"];
			$this->request->data["Scribble"]["ukey"] = $ukey;
			if ($this->Scribble->save($this->request->data)) {
				$this->Session->setFlash("Scribble updated");
			} else {
				$this->Session->setFlash("Scribble cannot be updated");
			}
		}

		if (!$this->request->data) {
			$this->request->data = $scribble;
		} else {
			$scribble = $this->request->data;
		}

		$this->set("scribble", $scribble);
	}
}
<?php
class ScribblesController extends AppController {
	public $helpers = array('Html', 'Form', 'Js' => array('Jquery'));
	public $components = array('RequestHandler');

	public function add() {
		if ($this->request->is("post")) {
			$this->Scribble->create();
			if (($new_scribble = $this->Scribble->save($this->request->data, array("title", "body")))) {
				$this->Session->setFlash("Scribble created!", "default", array("class" => "alert alert-success"));
				return $this->redirect(array("controller" => "Scribbles", "action" => "view", $new_scribble["Scribble"]["ukey"]));
			} else {
				$this->Session->setFlash("Scribble cannot be created. :(", "default", array("class" => "alert alert-danger"));
			}
		}
	}

	public function view($ukey = null) {
		$json_request = $this->isJsonRequest();

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
				if ($json_request) {
					$this->set("status", "OK");
				} else {
					$this->Session->setFlash("Scribble updated", "default", array("class" => "alert alert-success"));
				}
			} else {
				if ($json_request) {
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

		$this->set("scribble", $scribble);

		if ($json_request) {
			if ($this->request->is("post") || $this->request->is("put")) {
				$this->set("_serialize", array("status", "scribble"));
			} else {
				$this->set("message", "JSON not allowed");
				$this->set("_serialize", array("message"));
			}
		}
	}

	private function isJsonRequest() {
		//Check if current request ask for a JSON response
		return (array_key_exists("REQUEST_URI", $_SERVER) && strtolower(substr($_SERVER['REQUEST_URI'], -5)) == '.json') || (array_key_exists("HTTP_ACCEPT", $_SERVER) && in_array("application/json", preg_split("/,\\s*/", strtolower($_SERVER["HTTP_ACCEPT"]))));
	}
}
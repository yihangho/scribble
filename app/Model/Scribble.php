<?php
class Scribble extends AppModel {
	public $validate = array(
		"body" => array(
			'rule'    => 'notEmpty',
			'message' => 'Body cannot be left empty'
			)
		);
	public function beforeSave($options = array()) {
		if (empty($this->data["Scribble"]["title"])) {
			$this->data["Scribble"]["title"] = "Untitled Scribble";
		}

		if (!array_key_exists("id", $this->data["Scribble"]) || empty($this->findById($this->data["Scribble"]["id"])["ukey"])) {
			do {
				// This is improbable, but not impossible.
				// Fun fact: Exact probability is 36^(-8) = 3.54E-13
				$this->data["Scribble"]["ukey"] = substr(md5(rand()), 0, 7);
			} while($this->find('count', array("conditions" => array("ukey" => $this->data["Scribble"]["ukey"]))));
			
		}
		return true;
	}
}
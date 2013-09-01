<?php
class Scribble extends AppModel {
	public $validate = array(
		"body" => array(
			'rule'    => 'notEmpty',
			'message' => 'Body cannot be left empty'
			)
		);
	public function beforeSave($options = array()) {
		if (!array_key_exists("ukey", $this->data["Scribble"]) || empty($this->data["Scribble"]["ukey"])) {
			$this->data["Scribble"]["ukey"] = substr(md5(rand()), 0, 7);
		}
		if (empty($this->data["Scribble"]["title"])) {
			$this->data["Scribble"]["title"] = "Untitled Scribble";
		}
		return true;
	}
}
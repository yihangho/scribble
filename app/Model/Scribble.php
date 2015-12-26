<?php
class Scribble extends AppModel {

	public $belongsTo = 'User';

	public $validate = array(
		"body" => array(
			'rule'		=> 'notEmpty',
			'message'	=> 'Body cannot be left empty'
			)
		);

	public function beforeSave($options = array()) {
		if (empty($this->data["Scribble"]["title"])) {
			$this->data["Scribble"]["title"] = "Untitled Scribble";
		}

		if (!array_key_exists("id", $this->data["Scribble"]) || empty($this->findById($this->data["Scribble"]["id"])["Scribble"]["ukey"])) {
			do {
				// This is improbable, but not impossible.
				// Fun fact: Exact probability is 36^(-8) = 3.54E-13
				$this->data["Scribble"]["ukey"] = substr(md5(rand()), 0, 7);
			} while ($this->find('count', array("conditions" => array("ukey" => $this->data["Scribble"]["ukey"]))));
			$ukey = $this->data["Scribble"]["ukey"];
		} else {
			$ukey = $this->findById($this->data["Scribble"]["id"])["Scribble"]["ukey"];
		}

		if (!array_key_exists("id", $this->data["Scribble"]) || empty($this->findById($this->data["Scribble"]["id"])["short_link"])) {
			if ($_ENV['GOOGLE_API_KEY']) {
				$curl = curl_init("https://www.googleapis.com/urlshortener/v1/url?key=" . $_ENV['GOOGLE_API_KEY']);
			} else {
				$curl = curl_init("https://www.googleapis.com/urlshortener/v1/url");
			}
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			curl_setopt($curl, CURLOPT_POSTFIELDS, '{"longUrl": "' . Router::url(array('controller' => 'Scribbles', 'action' => 'view', $ukey), true) . '"}');
			$return = json_decode(curl_exec($curl), true);
			$this->data["Scribble"]["short_link"] = $return["id"];
		}
		return true;
	}
}

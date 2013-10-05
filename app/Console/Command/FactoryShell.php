<?php
class FactoryShell extends AppShell {
	public $uses = array('Scribble');

	public function scribble() {
		// $this->out('How many Scribbles to generate? [30]');
		$numberOfScribbles = $this->in('How many Scribbles to generate?', null, 30);
		$userId = $this->in('User id', null, 'NULL');
		$title = $this->in('Title', null, 'This is an automatically generated Scribble');
		$body = $this->in('Body', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor.');

		if (strtolower($userId) == "null") {
			$userId = null;
		}

		for ($i=0; $i<$numberOfScribbles; $i++) {
			$this->Scribble->create();
			$this->Scribble->save(array('Scribble' => array(
				'user_id' => $userId,
				'title' => $title,
				'body' => $body
				)));
		}
	}
}

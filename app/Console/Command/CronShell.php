<?php
class CronShell extends AppShell {

	public $uses = array('Scribble', 'Statistic');

	public function main() {
		$results = $this->Scribble->find('count');
		$this->Statistic->create();
		$this->Statistic->save(array('Statistic' => array(
			'value' => $results
			)));
	}
}

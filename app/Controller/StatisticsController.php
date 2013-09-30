<?php
class StatisticsController extends AppController {

	public function index() {
		if (!$this->currentUser || !$this->currentUser["User"]["admin"]) {
			return $this->redirect(Router::url(array('controller' => 'Scribbles', 'action' => 'add')));
		}
		$statistics = $this->Statistic->find('all', array('order' => array('created ASC')));
		$output = array();
		foreach($statistics as $s) {
			$output[] = array(new DateTime($s["Statistic"]["created"]), $s["Statistic"]["value"]);
		}
		$this->set('statistics', $output);
	}
}

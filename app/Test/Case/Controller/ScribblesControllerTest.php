<?php
class ScribblesControllerTest extends ControllerTestCase {

	public $fixtures = array('app.scribble');

	public function testCreateNewScribble() {
		// When creating new Scribble, there should be a header indication 'New Scribble'
		// and there should be a textarea to input text.
		$result = $this->testAction(Router::url(array('controller' => 'Scribbles', 'action' => 'add')), array('return' => 'view', 'method' => 'get'));
		$this->assertTag(array(
			'tag' => 'textarea',
			'content' => ''
			), $result, 'There should be an empty textarea.');
		$this->assertRegExp('/New Scribble/', $result, 'There should be a "New Scribble" title.');
	}

	public function testSavingNewValidScribble() {
		// When saving a new valid Scribble, the user should be redirected to another page.
		// This page should contain the new Scribble (its title and body)
		$inputData = array('Scribble' => array(
			'title' => 'I am a Scribble created by unit test',
			'body' => 'See? I am not empty!'
			));
		$this->testAction(Router::url(array('controller' => 'Scribbles', 'action' => 'add')), array('data' => $inputData));
		$this->assertStringMatchesFormat(Router::url(array('controller' => 'Scribbles', 'action' => 'view'), true) . '%s', $this->headers['Location'], 'The user should be redirected to another page.');
	}

	public function testSavingNewInvalidScribble() {
		// When saving a new invalid Scribble (body is empty), that Scribble should be rejected
		$inputData = array('Scribble' => array(
			'title' => 'My body is empty',
			'body' => ''
			));
		$result = $this->testAction(Router::url(array('controller' => 'Scribbles', 'action' => 'add')), array('data' => $inputData, 'return' => 'contents'));
		$this->assertRegExp('/cannot be created/', $result, 'The rendered view should contain a message saying that the new Scribble cannot be created.');
	}

	public function testViewExistingScribble() {
		// When viewing an existing Scribble, there should be a textbox with existing body.
		$result = $this->testAction(Router::url(array('controller' => 'Scribbles', 'action' => 'view', '1234567')), array('method' => 'get', 'return' => 'view'));
		$this->assertTag(array(
			'tag' => 'textarea',
			'content' => 'I am a Scribble!'
			), $result, 'The should be a textarea with existing body.');
	}
}

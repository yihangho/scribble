<?php
class ScribbleTest extends CakeTestCase {

	public $fixtures = array('app.scribble', 'app.user');

	public function setUp() {
		parent::setUp();
		$this->Scribble = ClassRegistry::init('Scribble');
	}

	public function testBodyNotEmptyValidation() {
		// Body should not be empty
		$inputData = array(
			'Scribble' => array(
				'title' => 'Another test Scribble.',
				'body' => ''
				)
			);
		$this->Scribble->create();
		$result = $this->Scribble->save($inputData);
		$this->assertFalse($result, "Scribble with empty body should not be saved.");
	}

	public function testDefaultTitle() {
		// A default title should be given when title is empty
		$inputData = array(
			'Scribble' => array(
				'title' => '',
				'body' => 'I am another test Scribble!'
				)
			);
		$this->Scribble->create();
		$result = $this->Scribble->save($inputData);
		$this->assertGreaterThan(0, strlen($result["Scribble"]["title"]));
	}

	public function testEditExistingScribble() {
		// Saving an existing Scribble should update its title and body
		$inputData = array(
			'Scribble' => array(
				'id' => 1,
				'title' => 'My new title',
				'body' => 'I am a test Scribble, now with new content!'
				)
			);
		$this->Scribble->id = 1;
		$this->Scribble->save($inputData);
		$result = $this->Scribble->findById(1);
		$this->assertEquals($inputData["Scribble"]["title"], $result["Scribble"]["title"], 'The title should be updated.');
		$this->assertEquals($inputData["Scribble"]["body"], $result["Scribble"]["body"], 'The body should be updated');
		$this->assertEquals('1234567', $result["Scribble"]["ukey"], 'The ukey should remain unchanged');
	}
}

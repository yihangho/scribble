<?php
class ScribbleFixture extends CakeTestFixture {

	public $useDbConfig = 'test';

	public $import = 'Scribble';

	public $records = array(
		array('id' => 1, 'title' => 'Test Scribble', 'body' => 'I am a Scribble!', 'ukey' => '1234567', 'short_link' => 'http://www.example.com', 'created' => '2013-10-12 01:01:01', 'modified' => '2013-10-12 01:01:01')
	);
}

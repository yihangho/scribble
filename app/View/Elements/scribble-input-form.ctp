<?php
echo $this->Form->create("Scribble");
echo $this->Form->input("title");
echo $this->Form->input("body", array("rows" => "3", "onkeyup" => "Preview.Update()", "id" => "ScribbleInput"));
if (isset($edit) && $edit === true)
	echo $this->Form->input("id", array("type" => "hidden"));
echo $this->Form->end("Scribble!");
?>
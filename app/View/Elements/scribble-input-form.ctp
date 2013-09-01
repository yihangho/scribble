<?php
echo $this->Form->create("Scribble", array("role" => "form"));
echo $this->Form->input("title", array("class" => "form-control", "div" => array("class" => "form-group")));
echo $this->Form->input("body", array("rows" => "3", "onkeyup" => "Preview.Update()", "id" => "ScribbleInput", "class" => "form-control", "style" => "", "div" => array("class" => "form-group")));
if (isset($edit) && $edit === true)
	echo $this->Form->input("id", array("type" => "hidden"));
echo $this->Form->submit("Scribble!", array("class" => "btn btn-default"));
echo $this->Form->end();
?>
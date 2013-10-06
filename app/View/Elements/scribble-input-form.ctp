<?php
if (!isset($prevent_default)) $prevent_default = false;
echo $this->Form->create("Scribble", array("role" => "form", "default" => !$prevent_default));
echo $this->Form->input("title", array("class" => "form-control", "div" => array("class" => "form-group")));
echo $this->element("latex-selector");
echo $this->Form->input("body", array("rows" => "10", "id" => "ScribbleInput", "class" => "form-control", "style" => "", "div" => array("class" => "form-group")));
if (isset($edit) && $edit === true)
	echo $this->Form->input("id", array("type" => "hidden"));
if (!isset($scribble) || !$scribble["Scribble"]["read_only"]) {
	echo $this->Form->submit("Scribble!", array("class" => "btn btn-default"));
}
echo $this->Form->end();
?>

<h1>Create new Scribble</h1>
<?php
echo $this->Form->create("Scribble");
echo $this->Form->input("title");
echo $this->Form->input("body", array("rows" => "3"));
echo $this->Form->end("Scribble!");
?>
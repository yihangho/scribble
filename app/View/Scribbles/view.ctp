<?php
echo $this->element("mathjax-js");
?>

<h1><?php echo $scribble["Scribble"]["title"];?></h1>
<div id="ScribblePreview" class="well well-lg"><?php echo nl2br($scribble["Scribble"]["body"]);?></div>
<div id="ScribbleBuffer" class="well well-lg" style="display:none;"></div>
<?php
echo $this->element("scribble-input-form", array("edit" => true));
?>
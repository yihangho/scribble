<?php
echo $this->element("mathjax-js");
?>

<h1><?php echo $scribble["Scribble"]["title"];?></h1>
<div id="ScribblePreview"><?php echo nl2br($scribble["Scribble"]["body"]);?></div>
<div id="ScribbleBuffer"></div>
<?php
echo $this->element("scribble-input-form", array("edit" => true));
?>
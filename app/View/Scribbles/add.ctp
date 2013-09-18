<?php
echo $this->element('mathjax-js');
?>

<h1>New Scribble</h1>
<div id="ScribblePreview" class="well well-lg" style="display:none;"></div>
<div id="ScribbleBuffer" class="well well-lg" style="display:none;"></div>
<?php
echo $this->element("scribble-input-form");
?>

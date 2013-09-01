<?php
echo $this->Html->scriptBlock("MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}});", array("type" => "text/x-mathjax-config"));
echo $this->Html->script("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
echo $this->Html->script("mathjax-livepreview");
?>

<h1><?php echo $scribble["Scribble"]["title"];?></h1>
<div id="ScribblePreview"><?php echo nl2br($scribble["Scribble"]["body"]);?></div>
<div id="ScribbleBuffer"></div>
<?php
echo $this->Form->create("Scribble");
echo $this->Form->input("title");
echo $this->Form->input("body", array("rows" => "3", "onkeyup" => "Preview.Update()", "id" => "ScribbleInput"));
echo $this->Form->input("id", array("type" => "hidden"));
echo $this->Form->end("Scribble!");
?>
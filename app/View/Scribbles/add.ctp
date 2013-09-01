<?php
echo $this->Html->scriptBlock("MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}});", array("type" => "text/x-mathjax-config"));
echo $this->Html->script("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
echo $this->Html->script("mathjax-livepreview");
?>
<h1>Create new Scribble</h1>
<?php
echo $this->Form->create("Scribble");
echo $this->Form->input("title");
echo $this->Form->input("body", array("rows" => "3", "onkeyup" => "Preview.Update()", "id" => "ScribbleInput"));
echo $this->Form->end("Scribble!");
?>
<div id="ScribblePreview"></div>
<div id="ScribbleBuffer"></div>
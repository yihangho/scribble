<?php
echo $this->Html->scriptBlock("MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}});", array("type" => "text/x-mathjax-config"));
echo $this->Html->script("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
?>

<h1><?php echo $scribble["Scribble"]["title"];?></h1>
<p>
	<?php echo nl2br($scribble["Scribble"]["body"]);?>
</p>
<?php
echo $this->Form->create("Scribble");
echo $this->Form->input("title");
echo $this->Form->input("body", array("rows" => "3"));
echo $this->Form->input("id", array("type" => "hidden"));
echo $this->Form->end("Scribble!");
?>
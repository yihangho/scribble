<?php
echo $this->Html->scriptBlock("MathJax.Hub.Config({messageStyle: \"none\"});", array("type" => "text/x-mathjax-config"));
echo $this->Html->script("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
echo $this->Html->script("jquery.caret");//Required for mathjax-preview to work
echo $this->Html->script("mathjax-livepreview");
?>
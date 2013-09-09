<?php
echo $this->Html->css('tutorial');
echo $this->Html->script('tutorial');
echo $this->element('mathjax-js');
?>
<h1>\(\LaTeX\) Tutorial</h1>
<div class="alert alert-warning alert-dismissable" style="display:none;" id="tutorial-alert">
	<button type="button" class="close" aria-hidden="true" onclick="$('div#tutorial-alert').fadeOut();">&times;</button>
	<strong>Hmm...</strong> <span id="alert-message"></span>
</div>
<div class="panel panel-default" id="tutorial">
	<div class="panel-body" id="instruction"></div>
	<div class="panel-footer" style="overflow:hidden;">
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default tutorial-change-step" id="prev" disabled data-force=true>Prev</button>
			<button type="button" class="btn btn-default tutorial-change-step" id="reset" disabled data-force=true>Reset</button>
			<button type="button" class="btn btn-default tutorial-change-step" id="next" data-goto=2>Next</button>
		</div>
	</div>
</div>
<div id="ScribblePreview" class="well well-lg" style="display:none;"></div>
<div id="ScribbleBuffer" class="well well-lg" style="display:none;"></div>
<?php
echo $this->element("latex-selector");
echo $this->Form->input("body", array("rows" => "10", "id" => "ScribbleInput", "class" => "form-control", "label" => false, "style" => "display:none;", "div" => array("class" => "form-group")));
?>
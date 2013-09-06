<?php
echo $this->element("mathjax-js");
?>
<script>var current_xhr = false;</script>
<h1><?php echo $scribble["Scribble"]["title"];?></h1>
<div id="ScribblePreview" class="well well-lg"><?php echo nl2br($scribble["Scribble"]["body"]);?></div>
<div id="ScribbleBuffer" class="well well-lg" style="display:none;"></div>
<div id="ajax_status"></div>
<?php
echo $this->element("scribble-input-form", array("edit" => true, "prevent_default" => true));
$form_data = $this->Js->get('#ScribbleViewForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#ScribbleViewForm')->event(
          'submit',
        $ajax_obj = $this->Js->request(
            array('action' => 'view', $scribble["Scribble"]["ukey"].".json"),
            array(
                    'data' => $form_data,
                    'async' => true,    
                    'dataExpression'=>true,
                    'method' => 'POST',
                    'dataType' => 'json',
                    'before' => 'if (current_xhr) current_xhr.abort(); current_xhr = XMLHttpRequest; if (!$("div#flashMessage").length) $("div#content").prepend("<div id=\"flashMessage\" style=\"display:none;\"></div>");',
                    'success' => 'if (data.status == "OK") $("div#flashMessage").text("Scribble updated!").removeClass().addClass("alert alert-success").show(); else $("div#flashMessage").text("Scribble cannot be saved.").removeClass().addClass("alert alert-danger").show(); setTimeout(function(){$("div#flashMessage").fadeOut();}, 10000);',
                    'error' => '$("div#flashMessage").text("Cannot communicate with server. Please refresh page and try again.").removeClass().addClass("alert alert-danger").show();',
                    'complete' => 'current_xhr = false;'
                )
            )
        );
?>
<?php
echo $this->element("mathjax-js");
?>
<script>
var current_xhr = false;
var short_url = "<?php echo $scribble["Scribble"]["short_link"];?>";

$(document).ready(function(){
    $("button#share").popover({
        html: true,
        placement: "bottom",
        content: '<div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon">⌘+C</span><input type="text" class="form-control" onclick="this.select();" value="'+short_url+'"></div><div style="text-align: center;"><a class="zocial facebook icon" onclick="facebook_share();"></a><a class="zocial googleplus icon" onclick="googleplus_share();"></a><a class="zocial twitter icon" onclick="twitter_share();"></a></div>',
        container: '#popover-container'
    });
});
</script>
<h1><?php echo $scribble["Scribble"]["title"];?><button id="share" class="btn btn-info pull-right" data-toggle="popover">Share</button></h1>
<div id="popover-container"></div>
<div id="ScribblePreview" class="well well-lg"><?php echo nl2br($scribble["Scribble"]["body"]);?></div>
<div id="ScribbleBuffer" class="well well-lg" style="display:none;"></div>
<div id="ajax_status"></div>
<?php
if (!$scribble["Scribble"]["read_only"]) {
	echo $this->element("scribble-input-form", array("edit" => true, "prevent_default" => true));
}
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

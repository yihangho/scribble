$(document).ready(function(){
	// Difference with the version in latex-editor
	// - tutorial_content is hardcoded using the JSON file provided in latex-editor
	// - load_tutorial() is removed
	// - tutorial is being shown by default
	
	// "Global variable"
	var animation_prev_element = false;
	var tutorial_content = [{"instruction":"Welcome to the \\(\\LaTeX\\) tutorial brought to you by Scribble! Before we get started, it is good that we get familiar with the user interface here. Click Next to continue.","render":true},{"textarea":"show","animate":"textarea","instruction":"What is shown to you right now is the <strong>textarea</strong>. It is there for you to write stuff down."},{"textarea":"show","textarea-text":"Hello World!","instruction":"The grey box that appears above the textarea is the <strong>live preview box</strong>. Everything that you have written in the textarea will be shown there. Try it out!"},{"textarea":"show","selector":"show","textarea-text":"Hello World!","instruction":"The grey box that is sandwiched between the live preview box and textarea is the \\(\\LaTeX\\) <strong>selector</strong>. Basically, this selector allows you to use \\(\\LaTeX\\) without knowing its markup language.","render":true},{"textarea":"show","selector":"show","reset":true,"textarea-text":"Let's try out the inline mode: Lorem ipsum dolor sit amet, consectetur adipiscing elit.","instruction":"In \\(\\LaTeX\\), there are two modes to enter math: inline mode and displayed mode. We shall see what inline mode is first. In the textarea below, move the cursor to right after the colon, and choose 'Inline mode' from the selector.<br>When you are ready, click Next. If you think you screwed something up, just click Reset.","render":true},{"regex":"\\\\\\(\\s*\\\\\\)","textarea":"show","selector":"show","reset":true,"textarea-text":"Let's try out the inline mode:\\( \\) Lorem ipsum dolor sit amet, consectetur adipiscing elit.","instruction":"You should be able to see that '\\( \\)' appears right after the colon. This is the delimiter for inline mode - we will be entering all the math stuff in between this pair. Now, move the cursor to right before the second slash, click 'Common' in the selector and choose 'Square root'.<br>Click next when you are ready and, again, if you think you're stuck, click Reset."},{"regex":"\\\\\\(\\s*\\\\sqrt\\{\\s*b\\s*\\}\\s*\\\\\\)","textarea":"show","selector":"show","textarea-text":"Let's try out the inline mode:\\( \\sqrt{b}\\) Lorem ipsum dolor sit amet, consectetur adipiscing elit.","instruction":"That's right. You should now be able to see a beautifully rendered square root sign in the live preview box. From what we can see now, the math symbol appears in between other text outside the delimiter - it can be said that the math symbol is shown <em>inline</em> with other text, hence, it is called inline mode. Before we move on, please feel free to experiment with other symbols. Also, try to change the \\(b\\) in the square root to something else.<br>When you are ready, click Next.","render":true},{"textarea":"show","selector":"show","reset":true,"textarea-text":"Let's try out the displayed mode this time: Curabitur sodales, lectus eget auctor egestas, diam odio egestas sem, a tincidunt nibh tellus ut risus.","instruction":"This time, we are going to see what displayed mode is. Just like last time, move the cursor in the textarea below to right after the colon. This time, choose Displayed mode from the selector."},{"regex":"\\\\\\[\\s*\\\\\\]","textarea":"show","selector":"show","reset":true,"textarea-text":"Let's try out the displayed mode this time:\\[ \\] Curabitur sodales, lectus eget auctor egestas, diam odio egestas sem, a tincidunt nibh tellus ut risus.","instruction":"Great work! Now, move the cursor to right before the second slash. Click Series from the selector and then choose Sigma notation.<br>When you're done, click Next. If you messed things up, click Reset."},{"regex":"\\\\\\[\\s*\\\\sum\\s*\\^\\s*\\{\\s*n\\s*\\}\\s*_\\s*\\{\\s*i\\s*\\=\\s*0\\s*\\}\\s*a\\s*_\\s*i\\s*\\\\\\]","textarea":"show","selector":"true","textarea-text":"Let's try out the displayed mode this time:\\[ \\sum^{n}_{i=0}a_i\\] Curabitur sodales, lectus eget auctor egestas, diam odio egestas sem, a tincidunt nibh tellus ut risus.","instruction":"Nice. As you can see, although the syntax for sigma notation appears in between other text, it is shown on its own line and is centered. This is how displayed mode shows math formula. Also take note that the delimiter for displayed mode is \\[ \\] while the delimiter for inline mode is \\( \\).<br>You have now reached the end of the tutorial. The operating model of Scribble is almost the same as what you have seen here, except you can specify a (optional) title and have to save when you're ready. Feel free to experiment with other symbols using inline mode or displayed mode before you go. Have fun!"}];

	// DOMs
	var textarea = $("textarea#ScribbleInput");
	var preview = $("div#ScribblePreview");
	var buffer = $("div#ScribbleBuffer");
	var selector = $("div#latex-selector");
	var prev_button = $("button#prev");
	var next_button = $("button#next");
	var reset_button = $("button#reset");
	var alert_bar = $("div#tutorial-alert");
	var instruction = $("div#instruction");

	// Function definition
	function animate(element) {
		kill_animation();
		element.addClass('animated tada');
		animation_prev_element = element;
	}

	function kill_animation() {
		if (animation_prev_element) {
			animation_prev_element.removeClass('animated tada');
			animation_prev_element = false;
		}
	}

	function update_step_attr(cur_step) {
		// Update the data-goto attribute for the buttons
		prev_button.data("goto", cur_step-1);
		next_button.data("goto", cur_step+1);
		reset_button.data("goto", cur_step);

		if (cur_step > 1) {
			prev_button.removeAttr("disabled");
		} else {
			prev_button.attr("disabled", "");
		}

		if (cur_step < tutorial_content.length) {
			next_button.removeAttr("disabled");
		} else {
			next_button.attr("disabled", "");
		}

		if ("reset" in tutorial_content[cur_step-1] && tutorial_content[cur_step-1]["reset"]) {
			reset_button.removeAttr("disabled");
		} else {
			reset_button.attr("disabled", "");
		}
	}

	function hide_all() {
		textarea.hide();
		selector.hide();
		preview.hide();
		buffer.hide();
		alert_bar.hide();
		kill_animation();
	}

	function goto(step, force) {
		if (step <= 0 || step > tutorial_content.length) {
			return;
		}

		var cur_step = tutorial_content[step-1];

		if (!force && "regex" in cur_step && !(new RegExp(cur_step["regex"]).test(textarea.val()))) {
			alert_bar.fadeIn();
			return;
		}

		hide_all();

		if ("textarea" in cur_step && cur_step["textarea"] == "show") {
			textarea.show();
		}

		if ("selector" in cur_step && cur_step["selector"] == "show") {
			selector.show();
		}

		if ("animate" in cur_step) {
			if (cur_step["animate"] == "textarea") {
				animate(textarea);
			}
			// TODO: Handle other objects
		}

		if ("textarea-text" in cur_step) {
			textarea.val("");
			textarea.keyup();
			setTimeout(function(){
				textarea.val(cur_step["textarea-text"]);
				textarea.keyup();
			}, 200);
		}

		instruction.html(cur_step["instruction"]);

		if ("render" in cur_step && cur_step["render"]) {
			MathJax.Hub.Queue(["Typeset",MathJax.Hub,"instruction"]);
		}

		update_step_attr(step);
	}

	// Event listeners
	$("button.tutorial-change-step").click(function(){
		goto($(this).data("goto"), $(this).data("force"));
	});

	goto(1);
});
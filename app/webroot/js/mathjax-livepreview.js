var Preview = {
	delay: 150,
	preview: null,
	buffer: null,
	timeout: null,
	mjRunning: false,
	oldText: null,

	Init: function () {
		this.preview = $("div#ScribblePreview");
		this.buffer = $("div#ScribbleBuffer");
	},

	SwapBuffers: function () {
		var buffer = this.preview, preview = this.buffer;
		this.buffer = buffer; this.preview = preview;
		buffer.hide();
		preview.show();
	},

	Update: function () {
		if (!this.preview) this.preview = $("div#ScribblePreview");
		if (!this.buffer) this.buffer = $("div#ScribbleBuffer");
		if (this.timeout) {clearTimeout(this.timeout)}
		this.timeout = setTimeout(this.callback,this.delay);
	},

	CreatePreview: function () {
		Preview.timeout = null;
		if (this.mjRunning) return;
		var text = document.getElementById("ScribbleInput").value;
		if (text === this.oldtext) return;
		this.buffer.html(this.oldtext = text);
		this.mjRunning = true;
		MathJax.Hub.Queue(
			["Typeset",MathJax.Hub,this.buffer.get(0)],
			["PreviewDone",this]
		);
	},

	PreviewDone: function () {
		this.mjRunning = false;
		this.SwapBuffers();
	}
};

Preview.callback = MathJax.Callback(["CreatePreview",Preview]);
Preview.callback.autoReset = true;
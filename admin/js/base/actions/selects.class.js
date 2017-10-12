var selects = function (settings) {
	this.settings = $.extend({
		'element' : '.select',
		'message' : '.message',
		'active'  : '.active',
		'beforeAjax'   : function () {},
		'successAjax'  : function () {},
		'completeAjax' : function () {}
	}, settings||{});

	this.loader = new loader;
	this.errors  = new errors(this.settings);

	this.setSettings = function (sources) {
		this.settings = $.extend(this.settings, sources||{});return this;
		this.errors  = new errors(this.settings);
	}

	this.init = function () {
		this.loader.init();
		var that = this;
		$(this.settings.element).live("change", function () {
			var access = true;
			that.setActive($(this));

			if ($(this).hasClass('confirm'))
				if (!confirm($(this).data('confirm')||'Do you sure?'))
					access = false;

			if (access)
				that.start();
				that.element$ = $(this);

				return false;
			});
		return this;
	}

	this.setActive = function (button$) {
		button$.addClass(this.settings.active.replace('.', ''));
		this.settings.element = this.settings.element + this.settings.active;

		return this;
	}

	this.start = function () {
			this.loader.start();
			this.errors.reset();
			this.setData()
				.setMethod()
				.setAction()
				.startAction();
		return this;
	}

	this.setCallback = function (callback) {
		if($.isFunction(callback))
			this.callback = callback;

		return this;
	}

	this.setData = function () {
		this.data = $(this.settings.element).serialize();

		return this;
	}

	this.setAction = function () {
		this.action = $(this.settings.element).data('action');

		return this;
	}

	this.setMethod = function () {
		this.method = $(this.settings.element).data('method');

		return this;
	}

	this.startAction = function () {
		var that = this;
		if ("errorsCounter" in window) {} else {
			$.ajax({
				beforeSend: $.proxy(that.before, that),
				error: $.proxy(that.error, that),
				url: that.action,
				type: that.method || 'post',
				dataType: 'json',
				data: that.data,
				success: $.proxy(that.success, that),
				complete: $.proxy(that.complete, that)
			});
		}
		this.resetActive();

		return this;
	}

	this.before = function () {
		this.loader.title('Send to server...');
	}

	this.error = function () {
		alert('The request has failed. Please contact the developers!');
	}

	this.success = function (response) {
		if (typeof(response) == 'object') {
			this.errors.show(response);
		} else if (response == 1) {
			$(this.settings.message).text('Данные были обновлены!').fadeIn();
			var localCallback = $(this.settings.element).data('callback');
			if ($.isFunction(localCallback))
				window[localCallback]($(this.settings.element));
		}
		if($.isFunction(this.callback))
			this.callback(response, this.element$);
	}

	this.complete = function (response) {
		this.loader
			.title('Result received!')
			.stop();

		if ($.isFunction(this.settings.completeAjax))
			this.settings.completeAjax(response);
	}

	this.resetActive = function () {
		$(this.settings.element).removeClass(this.settings.active.replace('.', ''));
		this.settings.element = this.settings.element.replace(this.settings.active, '') ;

		return this;
	}
}
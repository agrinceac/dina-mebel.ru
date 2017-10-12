var form = function (settings) {
	this.settings = $.extend({
		'form'    : '.form',
		'active'  : '.active',
		'submit'  : '.submit',
		'message' : '.message',
		'onBeforeSend' : function () {},
		'onSuccess' : function () {},
		'onComplete' : function () {}
	}, settings||{});

	this.loader = new loader;
	this.errors  = new errors(this.settings);
	this.fieldSelector = 'input[type=text]:visible,input[type=password]:visible,input[type=hidden],input:checkbox:checked:visible,textarea:visible,select:visible';

	this.setSettings = function (sources) {
		this.settings = $.extend(this.settings, sources||{});
		this.errors  = new errors(this.settings);
		return this;
	}

	this.init = function () {
		this.loader.init();
		var that = this;
		$(this.settings.form + 'Submit').live("click", function () {
			that.setActive($(this))
				.start();
			return false;
		});
	}

	this.setActive = function (submit$) {
		if ($('form').length > 1 ) {
			if ( submit$.length >= 1 )
				if (!submit$.parents(this.settings.form).hasClass(this.settings.active.replace('.', ''))) {
					submit$.parents(this.settings.form).addClass(this.settings.active.replace('.', ''));
					this.settings.form = this.settings.form + this.settings.active;
				}
		} else if ( $('form').length == 1 ) {
			$(this.settings.form).addClass(this.settings.active.replace('.', ''));
			this.settings.form = this.settings.form + this.settings.active;
		}
		return this;
	}

	this.start = function (callback) {
			this.loader.start();
			this.errors.reset();
			if ($.isFunction(this.settings.onBeforeSend))
				this.settings.onBeforeSend(this);
			this.setCallback(callback)
				.setData()
				.setMethod()
				.setAction()
				.startAction();
		return this;
	}

	this.setCallback = function (callback) {
		if($.isFunction(callback)) {
			this.callback = callback;
		}
		return this;
	}

	this.getData = function () {
		return this.data;
	}

	this.setData = function () {
		this.data = this.serialize();
		return this;
	}

	this.serialize = function () {
		var data;
		if (this.isForm(this.settings.form))
			data = $(this.settings.form).serialize();
		else if (this.isDiv(this.settings.form)) {
			data = $.param($(this.settings.form).find(this.fieldSelector));
		}
		return data;
	}

	this.setAction = function () {
		if (this.isForm(this.settings.form))
			this.action = $(this.settings.form).attr('action');
		else if (this.isDiv(this.settings.form))
			this.action = $(this.settings.form).data('action');

		return this;
	}

	this.setMethod = function () {
		if (this.isForm(this.settings.form))
			this.method = $(this.settings.form).attr('method');
		else if (this.isDiv(this.settings.form))
			this.method = $(this.settings.form).data('method');

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

		return this;
	}

	this.before = function () {
		this.loader.title('Send to server...');
		$(this.settings.message).hide().html($(this.loading)).fadeIn();
	}

	this.error = function () {
		alert('Обратитесь к разработчикам. Операция '+this.action+' вызвала сбой.');
	}

	this.success = function (response) {
		$(this.settings.message).hide();

		if (typeof(response) == 'object') {
			this.errors.show(response);
		} else {
			$(this.settings.message).text((response==1)?'Данные были обновлены!':response).fadeIn();
		}

		if($.isFunction(this.callback))
			this.callback(response);

		if ($.isFunction(this.settings.onSuccess))
			this.settings.onSuccess(response, this);
	}

	this.complete = function (response) {
		this.loader
			.stop()
			.title('Result received!');
		this.resetActive();
		if ($.isFunction(this.settings.onComplete))
			this.settings.onComplete(response, this);
	}

	this.resetActive = function () {
		$(this.settings.form).removeClass('active');
		this.settings.form = this.settings.form.replace(this.settings.active, '');
	}

	this.isDiv = function (element) {
		var el = $(element);
		return $(element).is('div');
	}

	this.isForm = function (element) {
		return $(element).is('form');
	}

	this.reset = function () {
		this.data = {};
		$(this.settings.form).find(this.fieldSelector).each(function(i){
			if ($(this).is('select'))
				$(this).find('option').each(function(){
					$(this).removeAttr('selected');
				});
			else if ($(this).is('checkbox'))
				$(this).removeAttr('checked');
			else
				$(this).val('');
		});
	}

}
//window.form = new form();
//$(function () {
//window.form.init();
//});
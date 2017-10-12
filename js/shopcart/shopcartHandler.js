$(function(){
	try {
		(new shopcartHandler)
		.addGoodInShopcart()
		.removeGoodFromShopcart()
		.resetShopcart()
		.changeQuantity()
		.sendOrder()
		.inputsInit()
	} catch (e) {
		alert(e.message);
	}
});

var shopcartHandler = function () {

	this.shopcartObject = new shopcart;

	this.sources = {
		'addToShopcartButton'      : '.addToShopcart',
		'shopcartBar' : '.shopcartBar',
		'removeFromShopcartButton' : '.removeFromShopcart',
		'resetShopcartButton' : '.resetShopcart',
		'changeQuantityInput' : '.basket .quantity',
		'sendOrderButton' : '.sendOrder',
		'clientName'	:   'input[name=clientName]',
		'phone'		:   'input[name=phone]',
		'email'		:   'input[name=email]',
		'textToSend'	:   'textarea[name=textToSend]',
		'city'		:   'input[name=city]',
		'street'		:   'input[name=street]',
		'house'		:   'input[name=house]',
		'apartment'		:   'input[name=apartment]',
		'inCreditMark'		:   'input[name=inCreditMark]',
		'ref'		:   'input[name=ref]'
	};

	this.ajaxLoader = new ajaxLoader();

	this.addGoodInShopcart = function () {
		var that = this;
		$(that.sources.addToShopcartButton).live('click', function(){
			that.shopcartObject.addToShopcart($(this));
		});
		return this;
	};

	this.removeGoodFromShopcart = function () {
		var that = this;
		$(that.sources.removeFromShopcartButton).live('click', function(){
			that.shopcartObject.removeFromShopcart($(this));
		});
		return this;
	};

	this.resetShopcart = function () {
		var that = this;
		$(that.sources.resetShopcartButton).live('click', function(){
			that.shopcartObject.resetShopcart($(this));
		});
		return this;
	};

	this.changeQuantity = function () {
		var that = this;
		$(that.sources.changeQuantityInput).live('keyup', function(){
			that.shopcartObject.changeQuantity($(this));
		});
		return this;
	};

	this.sendOrder = function () {
		var that = this;
		$(that.sources.sendOrderButton).live('click', function(){
			that.shopcartObject.sendOrder($(this));
		});
		return this;
	};

	this.inputsInit = function () {
		var newInputs = new inputs;
		newInputs.setSettings({'element':'.inputs'}).init();
		return this;
	};
};
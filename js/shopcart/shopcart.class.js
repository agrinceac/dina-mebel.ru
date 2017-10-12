var shopcart = function (sources) {

	this.ajax = {
		'addToShopcart' : '/shopcart/ajaxAddGood/',
		'getShopcartBar' : '/shopcart/ajaxGetShopcartBar/',
		'removeFromShopcart' : '/shopcart/ajaxRemoveGood/',
		'getShopcartGoodsTable' : '/shopcart/ajaxGetShopcartGoodsTableContent/',
		'changeQuantity' : '/shopcart/ajaxChangeQuantity/',
		'resetShopcart' : '/shopcart/ajaxResetShopcart/',
		'sendOrder' : '/order/ajaxSendOrder/'
	};

	this.loader = new ajaxLoader();

	this.errors  = new errors({
		'form' : '.root',
		'error'   : '.hint',
		'showMessage' : 'showMessage'
	});

	this.addToShopcart = function (object) {
		var that = this;
		that.loader.setLoader( object );
		$.ajax({
			url: that.ajax.addToShopcart,
			type: 'POST',
			data: {
				'objectId' : $(object).attr('data-objectId'),
				'objectClass' : $(object).attr('data-objectClass'),
				'quantity' : $(object).attr('data-quantity')
			},
			dataType: 'json',
			success: function(data){
				that.loader.getElement();
				if(data == 1){
					that.errors.reset();
					that.updateShopcartBar();
				}
				else
					that.errors.show(data);
			}
		});
	};

	this.updateShopcartBar = function () {
		var that = this;
		$.ajax({
			url: that.ajax.getShopcartBar,
			type: 'POST',
			dataType: 'html',
			success: function(data){
				if(data){
					$((new shopcartHandler()).sources.shopcartBar).html(data).hide().fadeIn('slow');
				}
				else
					alert('Error while trying to update Shopcart Bar.');
			}
		});
	};

	this.removeFromShopcart = function (object) {
		var that = this;
		that.loader.setLoader( object );
		$.ajax({
			url: that.ajax.removeFromShopcart,
			type: 'POST',
			data: {
				'goodId' : $(object).attr('data-goodId'),
				'goodClass' : $(object).attr('data-goodClass'),
				'goodCode' : $(object).attr('data-goodCode'),
			},
			success: function(data){
				that.loader.getElement();
				if(data == 1)
					that.updateShopcartGoodsTable();
				else
					alert('Error while trying to delete good from shopcart');

			}
		});
	};

	this.updateShopcartGoodsTable = function (template) {
		var that = this;
		$.ajax({
			url: that.ajax.getShopcartGoodsTable,
			type: 'POST',
			data: {
				'template' : template
			},
			dataType: 'json',
			success: function(data){
				if(data){
					$('.placeForShopcartGoodsTable').html(data);
				}
				else
					alert('Error while trying to get shopcart goods table');
			}
		});
	};

	this.changeQuantity = function (object) {
		var that = this;
		$.ajax({
			url: that.ajax.changeQuantity,
			type: 'POST',
			data: {
				'goodId' : $(object).attr('data-goodId'),
				'goodClass' : $(object).attr('data-goodClass'),
				'goodCode' : $(object).attr('data-goodCode'),
				'quantity' : $(object).val(),
			},
			dataType: 'json',
			success: function(data){
				if(data == 1){
					that.errors.reset();
					that.updateShopcartGoodsTable();
				}
				else
					that.errors.show(data);
			}
		});
	};

	this.resetShopcart = function (object) {
		var that = this;
		that.loader.setLoader( object );
		$.ajax({
			url: that.ajax.resetShopcart,
			type: 'POST',
			dataType: 'json',
			success: function(data){
				that.loader.getElement();
				if(data == 1){
					that.updateShopcartGoodsTable();
					that.updateShopcartBar();
				}
				else
					alert('Error while trying to reset shopcart');
			}
		});
	};

	this.sendOrder = function (object) {
		var that = this;
		var handlerShopcart = (new shopcartHandler);
		that.loader.setLoader( object );
		var inCreditMark = +($(handlerShopcart.sources.inCreditMark).val());
		var data ={
			'clientName':   $(handlerShopcart.sources.clientName).val(),
			'phone'	:   $(handlerShopcart.sources.phone).val(),
			'email'	:   $(handlerShopcart.sources.email).val(),
			'textToSend':   $(handlerShopcart.sources.textToSend).val(),
			'city':   $(handlerShopcart.sources.city).val(),
			'street':   $(handlerShopcart.sources.street).val(),
			'house':   $(handlerShopcart.sources.house).val(),
			'apartment':   $(handlerShopcart.sources.apartment).val(),
			'inCreditMark':   inCreditMark,
			'ref':   $(handlerShopcart.sources.ref).val(),
		};
		$.ajax({
			url: that.ajax.sendOrder,
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(data){
				that.loader.getElement();
				that.errors.reset();
				if(data === 1){
//					that.updateShopcartGoodsTable('orderSent');
					that.updateShopcartGoodsTable( inCreditMark === 1   ?   'orderSentInCredit'   :   'orderSent' );
					console.log(yaCounter22453480.reachGoal("zakaz"));
					console.log(ga("send", "event", "zakaz", "done"));
				}
				else
					that.errors.show(data);
			}
		});
	};
}
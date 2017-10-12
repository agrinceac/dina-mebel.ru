$(function(){
	try {
		(new datePickerHandler)
	} catch (e) {
		alert(e.message);
	}
});

var datePickerHandler = function () {
	var that = this;
	this.initDatePicker = function(){
		var that = this;
		$('#datepicker').datepicker({
			minDate:0,
			onClose: function() {
				that.blockDates();
			}
		});
		var periodStart = new Date();
		if($.cookie('periodStart'))
			periodStart = $.cookie('periodStart');
		$('#datepicker').datepicker("setDate", periodStart);
		that.blockDates();
	}

	this.blockDates = function(){
		var that = this;
		$('#datepicker2').datepicker('destroy');
		$('#datepicker2').datepicker({
			minDate: $('#datepicker').val(),
			onClose: function() {
				that.countPeriod();
			}
		});
		var date = new Date();
		if($.cookie('periodEnd'))
			periodEnd = $.cookie('periodEnd');
		$('#datepicker2').datepicker("setDate", periodEnd);
		that.countPeriod();
	}

	this.countPeriod = function(){
		var that = this;
		var shopcartClass = (new shopcart());
		shopcartClass.errors.reset();
		var dt1 = $('#datepicker').val();
		var dt2 = $('#datepicker2').val();
		var days = that.getDays (dt1, dt2);


		if($.isNumeric(days)){
			$('.day').html(days);
			if ( $('.placeForShopcartGoodsTable').length  &&  dt1  &&  dt2 ){
				shopcartClass.changeQuantity(days);
				that.setDateCookies();
			}
			else{
				var finalSum = that.commafy (parseInt(days) * parseInt($('.goodPrice').attr('value')) );
				$('.finalSum').html(finalSum);
			}
		}
		else
			shopcartClass.errors.show({"datepicker2":"Выберите верный период"});
	}

	this.setDateCookies = function()
	{
		var that = this;
		if($.isNumeric( that.getDays ($('#datepicker').val(), $('#datepicker2').val()) )){
			$.cookie('periodStart', $('#datepicker').val(), { expires: 7, path: '/'});
			$.cookie('periodEnd', $('#datepicker2').val(), { expires: 7, path: '/'});
			$.cookie('periodDays', that.getDays ($('#datepicker').val(), $('#datepicker2').val()), { expires: 7, path: '/'});
		}
	}

	this.getDays = function(dt1, dt2) {
		function parse(dt) {
			return dt.replace(/(\d+).(\d+).(\d+)/, function(all, a, b, c){
				return (c < 100 ? +c + 2000 : c) + '.' + (+b - 1) + '.' + a;
			});
		}
		var outDT1 = (new Date(Date.UTC.apply(null, parse(dt1).split('.')))).getTime();
		var outDT2 = (new Date(Date.UTC.apply(null, parse(dt2).split('.')))).getTime();
		if(outDT1 > outDT2)
			return false;
		return (( outDT1 > outDT2 ? outDT1 - outDT2 : outDT2 - outDT1) / 1000 / 60 / 60 / 24) + 1;
	}

	this.commafy = function(num, sThousandsSeparator)
	{
		if(!sThousandsSeparator) {
			sThousandsSeparator = " ";
		}
		var bNegative = (num < 0);
		var sDecimalSeparator = ".";
		sOutput = num.toString();
		nDotIndex = sOutput.lastIndexOf(sDecimalSeparator);
		nDotIndex = (nDotIndex > -1) ? nDotIndex : sOutput.length;
		var sNewOutput = sOutput.substring(nDotIndex);
		var nCount = -1;
		for (var i=nDotIndex; i>0; i--) {
				nCount++;
				if ((nCount%3 === 0) && (i !== nDotIndex) && (!bNegative || (i > 1))) {
						sNewOutput = sThousandsSeparator + sNewOutput;
				}
				sNewOutput = sOutput.charAt(i-1) + sNewOutput;
		}
		sOutput = sNewOutput;
		return sOutput;
	}
};


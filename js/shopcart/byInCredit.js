$(function(){
	var minRef = 100000000000;
	var maxRef = 999999999999;
	var category = 'FURNITURE';

	var data = {
//		'inn'	: '7708828549',
		'inn'	: '5044095489',		// real inn
		'ref' : 'REF' + ( Math.floor(Math.random() * (maxRef - minRef + 1)) + minRef )
	};


	$('.byInCredit').click(function(){
		if(!validateAndShowErrors())
			return;

		var user = {
			'name' : $('input[name=clientName]').val(),
			'phone': $('input[name=phone]').val(),
			'email': $('input[name=email]').val()
		};

		var basket = [];
		$('.shopcartGoodRow').each(function(){
			basket[ $(this).find('.shopcartGoodName').html() ] = {
				'category'		: category,
				'code'			: '#' + $(this).find('.quantity').attr('data-goodId'),
				'description'	: $(this).find('.shopcartGoodName').html(),
				'amount'		: +($(this).find('.quantity').val()),
				'price'			: +($(this).find('.shopcartGoodPrice').attr('data-shopcartGoodPrice')),
				'img'			: $(this).find('.shopcartGoodImage').attr('src')
			};
		});
		sendClaimToAnketa(basket, user, data);
	});

});

function validateAndShowErrors(){
	(new errors()).reset();
	var validate = [];
	if( $('input[name=clientName]').val() === '' ){
		(new error($('input[name=clientName]'), $('input[name=clientName]').attr('data-errorMessage'))).show();
		validate.push(false);
	}
	if( $('input[name=phone]').val() === '' ){
		(new error($('input[name=phone]'), $('input[name=phone]').attr('data-errorMessage'))).show();
		validate.push(false);
	};
	return validate.indexOf(false) < 0;
}

function sendClaimToAnketa(basket, user, data){
//	console.log(basket, user, data);
//	return;

    var xml = document.implementation.createDocument('', '', null);
    var inParams = xml.createElement("inParams");
    //companyInfo
    var companyInfo =  xml.createElement("companyInfo");
        var inn = xml.createElement("inn");
        inn.textContent = data.inn;
    companyInfo.appendChild(inn);
    //creditInfo
    var creditInfo = xml.createElement("creditInfo");
    var reference = xml.createElement("reference");
    reference.textContent = data.ref;
    var firstPayment = xml.createElement("firstPayment");
    firstPayment.textContent = "0";
//        var creditPeriod = xml.createElement("creditPeriod");
//        var creditProductCode = xml.createElement("creditProductCode");
//        var shopCode = xml.createElement("shopCode");
    creditInfo.appendChild(reference);
    creditInfo.appendChild(firstPayment);
//    creditInfo.appendChild(creditPeriod);
//    creditInfo.appendChild(creditProductCode);
//    creditInfo.appendChild(shopCode);
    //clientInfo
    var clientInfo = xml.createElement("clientInfo");
//        var lastname = xml.createElement("lastname");
//            lastname.textContent = "";
        var firstname = xml.createElement("firstname");
            firstname.textContent = user.name;
//        var middlename = xml.createElement("middlename");
//        var passportNamber = xml.createElement("passportNamber");
//        var passportSeries = xml.createElement("passportSeries");
		if(user.email !== ''){
			var email = xml.createElement("email");
            email.textContent = user.email;
		}
        var mobphone = xml.createElement("mobphone");
            mobphone.textContent = user.phone;

//    clientInfo.appendChild(lastname);
    clientInfo.appendChild(firstname);
//    clientInfo.appendChild(middlename);
//    clientInfo.appendChild(passportNamber);
//    clientInfo.appendChild(passportSeries);
	if(user.email !== '')
		clientInfo.appendChild(email);
    clientInfo.appendChild(mobphone);
    //specificationList
    var specificationList = xml.createElement("specificationList");
    if (!$.isEmptyObject(basket)){
        for(var item in basket){
            var row = xml.createElement("specificationListRow");
            var desc = xml.createElement("description");
            desc.textContent = item;
            var amount = xml.createElement("amount");
            amount.textContent = basket[item].amount;
            var price = xml.createElement("price");
            price.textContent = basket[item].price;
            var category = xml.createElement("category");
            category.textContent = basket[item].category;
            var code = xml.createElement("code");
            code.textContent = basket[item].code;
            var img = xml.createElement("image");
			img.textContent = location.origin + basket[item].img;

            row.appendChild(code);
            row.appendChild(category);
            row.appendChild(desc);
            row.appendChild(amount);
            row.appendChild(price);
            row.appendChild(img);
            specificationList.appendChild(row);
        }
    }

    inParams.appendChild(companyInfo);
    inParams.appendChild(creditInfo);
    inParams.appendChild(clientInfo);
    inParams.appendChild(specificationList);
    //xml.appendChild(inParams);
    xml.appendChild(inParams);
    //<inParams>
    //    <companyInfo><inn>7804402344</inn></companyInfo>
    //    <creditInfo><reference>A0000000001</reference><firstPayment>0</firstPayment><creditPeriod>15</creditPeriod>
    //      <creditProductCode>JLAO</creditProductCode><shopCode>ALCT133_IS</shopCode>
    //    </creditInfo>
    //    <clientInfo><lastname>РђСЂСЃРµРЅС‚СЊРµРІ</lastname><firstname>РђРЅС‚РѕРЅ</firstname><middlename>РђРЅРґСЂРµРµРІРёС‡</middlename>
    //      <passportNumber>1212</passportNumber><passportSeries>123456</passportSeries><email>lol4e@gmail.com</email>
    //      <mobphone>9857715151</mobphone>
    //    </clientInfo>
    //
    //<specificationList><specificationListRow><category>CRT_TV</category><code>#123</code><description>Samsung</description>
    //  <amount>1</amount><price>10000</price></specificationListRow>
    //<specificationListRow><category>MOBILE_PHONE</category><code>#1222</code><description>HTC</description>
    //  <amount>2</amount><price>10000</price>
    //</specificationListRow>
    //</specificationList>
    //</inParams>"
    //var endpoint = "http://alfaformdev/alfaform-pos/endpoint";
//    var endpoint = "/alfaform-pos/endpoint";
    //var endpoint = "http://127.0.0.1:8085/alfaform-pos/endpoint";
	var endpoint = 'https://anketa.alfabank.ru/alfaform-pos/endpoint';
    var serializedXml = new XMLSerializer().serializeToString(xml);
    //post(endpoint, {InXML:xml.documentElement.outerHTML, testMode:true});
    singleBasket = {};

    // console.log( xml );
    // return;

    post(endpoint, {InXML:serializedXml, testMode:false}, 'post', data);
}


function post(path, params, method, data) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("accept-charset", "UTF-8");

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.setAttribute("target", "_blank");
            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();

	$('input[name=inCreditMark]').val(1);
	$('input[name=ref]').val(data.ref);
	$('.sendOrder').click();
}
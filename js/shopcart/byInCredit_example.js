$(function(){
//	$('.byInCredit').click(function(){
//		var loader = new ajaxLoader();
//		loader.setLoader(this);
//		$.ajax({
//			url: '/order/ajaxSendByInCredit/',
//			type: "POST",
//			data:{
//				'objectId'		: $(this).attr('data-objectId'),
//				'objectClass'	: $(this).attr('data-objectClass')
//			},
//			dataType: 'json',
//			success: function(data){
//				loader.getElement();
//				if(data === 1)
//					alert('ok');
//				else
//					alert('Error while trying to send request for buying in credit');
//			}
//		});
//	});

	var minRef = 100000000000;
	var maxRef = 999999999999;

	var data = {
		'inn'	: '7708828549',
		'ref' : 'REF' + ( Math.floor(Math.random() * (maxRef - minRef + 1)) + minRef )
	};


	$('.byInCredit').click(function(){
		(new errors()).reset();
		var validate = true;
		if( $('input[name=clientName]').val() === '' ){
			(new error($('input[name=clientName]'), 'Введите Ваше имя')).show();
			validate = false;
		}
		if( $('input[name=phone]').val() === '' ){
			(new error($('input[name=phone]'), 'Напишите номер телефона')).show();
			validate = false;
		};
		if(!validate)
			return;

		var basket = {
			1 : {
				'count' : 2,
				'cost'	: 10000,
				'img'	: '/cache/images/catalog/86x65/original_432.jpg'
			},
			2 : {
				'count' : 3,
				'cost'	: 60000,
				'img'	: '/cache/images/catalog/86x65/dia.jpg'
			},
			3 : {
				'count' : 4,
				'cost'	: 80000,
				'img'	: '/cache/images/catalog/86x65/roza.jpg'
			}
		};
		var user = {
			'name' : $('input[name=clientName]').val(),
			'phone': $('input[name=phone]').val(),
			'email': $('input[name=email]').val()
		};
		sendClaimToAnketa(basket, user, data);
	});

});

function sendClaimToAnketa(basket, user, data){

	console.log(basket, user, data);
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
//        var firstPayment = xml.createElement("firstPayment");
//        var creditPeriod = xml.createElement("creditPeriod");
//        var creditProductCode = xml.createElement("creditProductCode");
//        var shopCode = xml.createElement("shopCode");
    creditInfo.appendChild(reference);
//    creditInfo.appendChild(firstPayment);
//    creditInfo.appendChild(creditPeriod);
//    creditInfo.appendChild(creditProductCode);
//    creditInfo.appendChild(shopCode);
    //clientInfo
    var clientInfo = xml.createElement("clientInfo");
        var lastname = xml.createElement("lastname");
            lastname.textContent = "";
        var firstname = xml.createElement("firstname");
            firstname.textContent = user.name;
        var middlename = xml.createElement("middlename");
        var passportNamber = xml.createElement("passportNamber");
        var passportSeries = xml.createElement("passportSeries");
        var email = xml.createElement("email");
            email.textContent = user.email;
        var mobphone = xml.createElement("mobphone");
            mobphone.textContent = user.phone;

    clientInfo.appendChild(lastname);
    clientInfo.appendChild(firstname);
    clientInfo.appendChild(middlename);
    clientInfo.appendChild(passportNamber);
    clientInfo.appendChild(passportSeries);
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
            amount.textContent = basket[item].count;
            var price = xml.createElement("price");
            price.textContent = basket[item].cost;
            var category = xml.createElement("category");
            category.textContent = "CRT_TV";
            var code = xml.createElement("code");
            code.textContent = "#" + Math.floor((Math.random() * 100) + 1);
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
    post(endpoint, {InXML:serializedXml, testMode:true});
}


function post(path, params, method) {
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
//            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.setAttribute("target", "_blank");
            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}
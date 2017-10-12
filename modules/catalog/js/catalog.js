$(function(){
	var editCatalogInputs = new inputs;
	editCatalogInputs
		.setSettings({'element' : '.editCatalogInputs', 'event': 'blur'})
		.setCallback(function (response) {
			if ( typeof response !== 'number' )
				alert(response);
		})
		.init();

	var editCatalogInputs = new inputs;
	editCatalogInputs
		.setSettings({'element' : '.changeCashRate', 'event': 'blur'})
		.setCallback(function (response) {
			if ( typeof response === 'number' )
				reloadGoodsList();
			else
				alert(response);
		})
		.init();

	var editCatalogInputs = new inputs;
	editCatalogInputs
		.setSettings({'element' : '.editLogin', 'event': 'blur', 'showError':false})
		.setCallback()
		.init();
});
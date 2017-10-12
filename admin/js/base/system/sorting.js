$(function () {
	window.articlesSorting = new groupSorting({
		'element$' : $( "#objects-tbl" ).find( "tbody" ),
		'containment' : $( "#objects-tbl" )
	});
	window.articlesSorting.action = $('#objects-tbl').attr('data-sortUrlAction');
	articlesSorting.sortable().stylize();
})
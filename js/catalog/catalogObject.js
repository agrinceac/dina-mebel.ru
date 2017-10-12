$(function(){
	initTouchslider();
});

var initTouchslider = function()
{
	$(".touchslider").touchSlider({margin: 0});
	$('.touchslider-nav-item').live('click', function(){
		$(this).parents('ul').children('.private').removeClass('private');
		$(this).parent().addClass('private');
	});

	$('.bigImage').gallery();

	$('.size').on('click', function(){
		$('.touchslider-item.current').children('a').click();
	});

	$('.touchslider-nav ul li').click(function(){
		rightCrossMonitoring($(this));
		leftCrossMonitoring($(this));
	});


	var rightCrossMonitoring = function (element$) {
		var preview$   = $('.hidden-photo');
		var preImages$ = $('.hidden-photo ul');
		var image$ = element$;
		var imageLeft   = image$.offset().left;
		var previewLeft = preview$.offset().left;
		if ( imageLeft - 10 < previewLeft ) {
			var preImagesPosLeft = preImages$.position().left;
			var preImagesLeft = preImagesPosLeft  + image$.width() * 1.5;
			var index = preImages$.find(image$).index('.hidden-photo ul li');
			if ( index == 0 ) {
				preImages$.animate({ left: 0 }, 150);
			} else {
				preImages$.animate({ left: preImagesLeft }, 150);
			}
		}
		return this;
	};

	var leftCrossMonitoring = function (element$) {
		var preview$   = $('.hidden-photo');
		var preImages$ = $('.hidden-photo ul');
		var image$ = element$;
		var imageWidth = image$.width() + 5;
		var imageRight = (image$.offset().left + imageWidth ) - preview$.offset().left;
		var previewWidth = preview$.width();
		if ( imageRight + 10 >= previewWidth ) {
			var left = preImages$.position().left;
			if (  image$.index('.touchslider-nav ul li') !== $('.touchslider-nav ul li').length - 1  ) {
				left = left - imageWidth;
			} else if ( imageRight > previewWidth ) {
				left = left - ( imageRight - previewWidth );
			}
			preImages$.animate({ left: left }, 150);
		}
		return this;
	};
};
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/favicon.ico" />
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />

	<!-- Start: Meta Information -->

	<meta name='yandex-verification' content='4459fd140f195639' />

	<title><?=$this->getMetaTitle();?></title>
	<meta name="description" content="<?=$this->getMetaDescription();?>" />
	<meta name="keywords" content="<?=$this->getMetaKeywords();?>" />

    <meta name="yandex-verification" content="aa5a0872714a42b4" />

	<!-- End: Meta Information -->

	<!-- Start: CSS files -->
	<?
	$css = $this->getController('imploder')->css();
	$css->add('style.css', '/css/dia-mebel/')
		->add('errors.css', '/admin/js/base/actions/styles/');
	$css->printf('compact');
	?>
	<!-- End: CSS files -->

	<!-- Start: JS scripts -->
	<script type="text/javascript">
		var date_format = '<?=DATE_FORMAT?>';
		var dir_https   = '<?=DIR_HTTPS?>';
		var dir_http    = '<?=DIR_HTTP?>';
		var part        = '<?//=($this->isPart($this->getPart())) ? $this->getPart() : '';?>';
		var controller  = '<?=$this->getMainController()?>';
		var action      = '<?=$this->action?>';
	</script>
	<!-- End: JS scripts -->

	<!-- Start: JS files -->
	<?
	$js = $this->getController('imploder')->js();
	$js->add('jquery.js')
		->add('slides.js')
//		->add('iLoad.js', '/js/')
		->add('loader.class.js','/admin/js/base/actions/')
		->add('form.class.js','/admin/js/base/actions/')
		->add('feedbackHandler.js','/js/feedback/')
		->add('feedback.class.js','/js/feedback/')
		->add('shopcartHandler.js','/js/shopcart/')
		->add('shopcart.class.js','/js/shopcart/')
		->add('ajaxLoader.class.js')
		->add('errors.class.js','/admin/js/base/actions/')
		->add('error.class.js','/admin/js/base/actions/')
		->add('inputs.class.js','/admin/js/base/actions/')
		->add('loaderLight.class.js','/admin/js/base/actions/')
		->tagsPrint();
	?>

    <script type="text/javascript">
		$(document).ready(function($){
			jQuery(document).ready(function($){
				$('#slides').slides({
					play:5000,
					pause:2500,
					hoverPause: true
				});
			});

//			L.create();
		});
	</script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-78226777-1', 'auto');
        ga('send', 'pageview');
    </script>

    <!-- calltouch code -->
    <script type="text/javascript">
        var _alloka = {
            objects: {
                'd94d48f727446996': {
                    block_class: 'phone_alloka',
                    jivosite: false,
                    email: false
                }
            },
            trackable_source_types:  ["type_in", "utm"],
            last_source: false,
            use_geo: true
        };
    </script>
    <script src="https://analytics.alloka.ru/v4/alloka.js" type="text/javascript"></script>
    <!-- /calltouch code -->

</head>
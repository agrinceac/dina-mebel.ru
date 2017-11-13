<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" href="/favicon.ico" />
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />

	<!-- Start: Meta Information -->

	<meta name='yandex-verification' content='4459fd140f195639' />

	<title><?=$this->getMetaTitle();?></title>
	<meta name="description" content="<?=$this->getMetaDescription();?>" />
	<meta name="keywords" content="<?=$this->getMetaKeywords();?>" />
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
        (function (w, d, nv, ls) {
            var lwait = function (w, on, trf, dly, ma, orf, osf) {var pfx = "ct_await_", sfx = "_completed";if (!w[pfx + on + sfx]) {var ci = clearInterval, si = setInterval, st = setTimeout, cmld = function() {if (!w[pfx + on + sfx]) { w[pfx + on + sfx] = true;if ((w[pfx + on] && (w[pfx + on].timer))) { ci(w[pfx + on].timer);w[pfx + on] = null;}orf(w[on]);}};if (!w[on] || !osf) {if (trf(w[on])){cmld();} else {if (!w[pfx + on]) {w[pfx + on] = {timer: si(function () {if (trf(w[on]) || ma < ++w[pfx + on].attempt) {cmld();}}, dly), attempt: 0};}}} else {if (trf(w[on])) {cmld();} else {osf(cmld);st(function(){lwait(w, on, trf, dly, ma, orf);}, 0);}}}};
            var ct = function (w, d, e, c, n) {var a = 'all', b = 'tou', src = b + 'c' + 'h';src = 'm' + 'o' + 'd.c' + a + src; var jsHost = "https://" + src, p = d.getElementsByTagName(e)[0], s = d.createElement(e); var jsf = function (w, d, p, s, h, c, n) {s.async = 1;s.src = jsHost + "." + "r" + "u/d_client.js?param;" + (c ? "client_id" + c + ";" : "") + "ref" + escape(d.referrer) + ";url" + escape(d.URL) + ";cook" + escape(d.cookie) + ";attrs" + escape("{\"attrh\":" + n + ",\"ver\":170615}") + ";"; p.parentNode.insertBefore(s, p);};if (!w.jQuery) {var jq = d.createElement(e);jq.src = jsHost + "." + "r" + 'u/js/jquery-1.7.min.js';jq.onload = function () {lwait(w, 'jQuery', function (obj) {return (obj ? true : false);}, 30, 100, function () {jsf(w, d, d.getElementsByTagName(e)[0], s, jsHost, c, n);});};p.parentNode.insertBefore(jq, p);} else {jsf(w, d, p, s, jsHost, c, n);}};
            var gaid = function (w, d, o, ct, n) {if (!!o) {lwait(w, o, function (obj) {return (obj && obj.getAll ? true : false);}, 200, (nv.userAgent.match(/Opera|OPR\//) ? 10 : 20), function (gaCounter) {var clId = null;try {var cnt = gaCounter && gaCounter.getAll ? gaCounter.getAll() : null;clId = cnt && cnt.length > 0 && !!cnt[0] && cnt[0].get ? cnt[0].get('clientId') : null;} catch (e) {console.warn("Unable to get clientId, Error: " + e.message);}ct(w, d, 'script', clId, n);}, function (f) {w[o](function () {f(w[o]);})});} else {ct(w, d, 'script', null, n);}};
            var cid = function () {try {var m1 = d.cookie.match('(?:^|;)\\s*_ga=([^;]*)');if (!(m1 && m1.length > 1)) return null;var m2 = decodeURIComponent(m1[1]).match(/(\d+\.\d+)$/);if (!(m2 && m2.length > 1)) return null;return m2[1]} catch (err) {}}();
            if (cid === null && !!w.GoogleAnalyticsObject) {
                if (w.GoogleAnalyticsObject == 'ga_ckpr') w.ct_ga = 'ga'; else w.ct_ga = w.GoogleAnalyticsObject;
                if (typeof Promise !== "undefined" && Promise.toString().indexOf("[native code]") !== -1) { new Promise(function (resolve) {var db, on = function () {resolve(true)}, off = function () {resolve(false)}, tryls = function tryls() {try {ls && ls.length ? off() : (ls.x = 1, ls.removeItem("x"), off());} catch (e) {nv.cookieEnabled ? on() : off();}}; w.webkitRequestFileSystem ? webkitRequestFileSystem(0, 0, off, on) : "MozAppearance" in d.documentElement.style ? (db = indexedDB.open("test"), db.onerror = on, db.onsuccess = off) : /constructor/i.test(w.HTMLElement) ? tryls() : !w.indexedDB && (w.PointerEvent || w.MSPointerEvent) ? on() : off();}).then(function (pm) {
                    if (pm) {gaid(w, d, w.ct_ga, ct, 2);} else {gaid(w, d, w.ct_ga, ct, 3);}})} else {gaid(w, d, w.ct_ga, ct, 4);}
            } else {ct(w, d, 'script', cid, 1);}})
        (window, document, navigator, localStorage);
    </script>
    <!-- /calltouch code -->

</head>
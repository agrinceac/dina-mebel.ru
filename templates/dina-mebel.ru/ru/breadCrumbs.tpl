<p class="speedbar">
	<a href="/">Главная</a>
	  &nbsp;   /  &nbsp;

	<? $count=0; foreach($breadcrumbs as $breadcrumb): $count++;?>
		<? if (empty($breadcrumb['url'])): ?>
			<span><?=$breadcrumb['name']?></span>
		<? else: ?>
			<span><a href="<?=$breadcrumb['url']?>"><?=$breadcrumb['name']?></a></span>
		<? endif; ?>
		<? if($count < sizeof($breadcrumbs)): ?>
			  &nbsp;   /  &nbsp;
		<? endif; ?>
	<? endforeach; ?>
</p>
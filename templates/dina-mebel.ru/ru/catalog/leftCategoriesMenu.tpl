<p class="title"><img src="/images/bg/cat.png" alt=""> Каталог товаров</p>
<?if($categories): foreach($categories as $category): ?>
	<div class="razdel">
		<p class="name <?= $category->alias == $_REQUEST['action'] && !isset($_REQUEST[0]) ? 'current' : ''?>"><a href="<?=$category->getPath()?>"><?=$category->h1?></a></p>
		<?if($category->getChildren(array($activeCategoryStatus))):?>
		<ul>
		<?foreach($category->getChildren(array($activeCategoryStatus)) as $child):?>
			<li <?= isset($_REQUEST[0]) ? ($child->alias == $_REQUEST[0] ? 'class="current"' : '') : ''?>><a href="<?=$child->getPath()?>"><?=$child->getName()?></a></li>
		<?endforeach?>
		</ul>
		<?endif?>
	</div>
<?  endforeach; endif?>
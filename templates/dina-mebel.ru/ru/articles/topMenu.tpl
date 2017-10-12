<div class="menu_in">
	<ul>
		<li><a href="/" <?=$this->getREQUEST()['controller'] == '' ? 'class="current"' : ''?>>Главная</a></li>
		<?foreach($topMenu as $item):?>
		<li><a href="<?=$item->getPath()?>" <?=$this->getREQUEST()['action'] == $item->alias ? 'class="current"' : ''?> ><?=$item->name?></a></li>
		<?endforeach?>
	</ul>
</div>
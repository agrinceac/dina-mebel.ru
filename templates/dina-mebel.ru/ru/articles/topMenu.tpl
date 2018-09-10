<div class="menu_in menu_mobil">
	<ul class="main-menu">
		<li><a href="/" <?=$this->getREQUEST()['controller'] == '' ? 'class="current"' : ''?>>Главная</a></li>
		<?foreach($topMenu as $item):?>
		<li><a href="<?=$item->getPath()?>" <?=$this->getREQUEST()['action'] == $item->alias ? 'class="current"' : ''?> ><?=$item->name?></a></li>
		<?endforeach?>
	</ul>
	<button type="button" class="button-menu_mobil button-menu_mobil-htx">
		<span>toggle menu</span>
	</button> <!-- добавил кнопку -->
</div>
<div class="menu">
	<!--TODO:-->
	<?if($this->checkUserRight('articles')):?>
		<a href="/admin/articles/" <?= $this->getREQUEST()['controller']=='articles' ? 'class="underline" ' : ''?>>Статьи</a>
	<?endif?>
	<?if($this->checkUserRight('goods')):?>
		<a href="/admin/goods/" <?= $this->getREQUEST()['controller']=='goods' ? 'class="underline" ' : ''?>>Товары</a>
	<?endif?>
    <?if($this->checkUserRight('goods')):?>
        <a href="/admin/priority/" <?= $this->getREQUEST()['controller']=='priority' ? 'class="underline" ' : ''?>>Приоритеты</a>
    <?endif?>
	<?if($this->checkUserRight('settings')):?>
		<a href="/admin/settings/" <?= $this->getREQUEST()['controller']=='settings' ? 'class="underline" ' : ''?>>Настройки</a>
	<?endif?>
	<?if($this->checkUserRight('administrators')):?>
		<a href="/admin/administrators/" <?= $this->getREQUEST()['controller']=='administrators' ? 'class="underline" ' : ''?>>Администраторы</a>
	<?endif?>
</div>
<div class="more">
	<span href="#" class="toggleMoreMenu">Ещё</span>
	<div class="more-list">
		<div class="black-arrow"></div>
	</div>
</div>
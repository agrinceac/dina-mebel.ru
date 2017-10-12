<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
		<div class="main">
			<?$this->includeBreadcrumbs()?>
			<h1>Корзина</h1>
			<?=$this->getShopcartGoodsTableContent()?>
			<div class="clear"></div>
		</div>
		<div class="vote"></div>
	</div>
</div><!--root-->
<?$this->includeTemplate('footer')?>
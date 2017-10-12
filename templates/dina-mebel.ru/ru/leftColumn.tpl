<div class="left_col">
	<div class="col_in">
		<div class="left_menu">
			<?$this->getController('Catalog')->getLeftCategoriesBlock()?>
		</div>
	</div>
	<?if(isset($_SESSION['recentViewedCategories'])):?>
	<div class="view_tovar">
		<p class="title">Просмотренный товар:</p>
		<?foreach($_SESSION['recentViewedCategories'] as $id=>$alias):?>
		<div class="tovar">
			<p class="name">
				<a href="<?=$this->getController('Catalog')->getCategoryByAlias($alias)->getPath()?>">
					<?=$this->getController('Catalog')->getCategoryByAlias($alias)->getH1()?>
				</a>
			</p>
			<div class="image">
				<a href="<?=$this->getController('Catalog')->getCategoryByAlias($alias)->getPath()?>">
					<img src="<?=$this->getController('Catalog')->getMainGood($id)->getFirstImage()->getImage('230x164')?>" alt="" />
				</a>
			</div>
			<p class="more"><a href="<?=$this->getController('Catalog')->getCategoryByAlias($alias)->getPath()?>">подробнее</a></p>
			<p class="price"><span><?=number_format($this->getController('Catalog')->getMainGood($id)->getPriceByQuantity(1), 0, '.', ' ')?></span> руб.</p>
		</div>
		<?endforeach?>
	</div>
	<?endif?>
</div>
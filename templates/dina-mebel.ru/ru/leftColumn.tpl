<div class="left_col left_col__catalog"> <!-- добавил класс left_col__catalog -->
	<div class="col_in">
		<div class="left_menu">
			<?$this->getController('Catalog')->getLeftCategoriesBlock()?>
		</div>
	</div>

	<?if(isset($_SESSION['recentViewedCategories'])):?>
	<div class="view_tovar">
		<p class="title">Просмотренный товар:</p>
		<?foreach($_SESSION['recentViewedCategories'] as $id=>$alias):?>
        <?$viewedCategory = $this->getController('Catalog')->getCategoryByAlias($alias);?>
        <?if($viewedCategory):?>
        <?$mainGood = (new \modules\catalog\goods\lib\Goods())->getMainGoodByCategoryId($id);?>
        <?if(is_object($mainGood)  &&  get_class($mainGood)=='modules\catalog\goods\lib\Good'):?>
		<div class="tovar">
			<p class="name">
				<a href="<?=$viewedCategory->getPath()?>">
					<?=$viewedCategory->getH1()?>
				</a>
			</p>
			<div class="image">
				<a href="<?=$viewedCategory->getPath()?>">
					<img src="<?=$mainGood->getFirstImage()->getImage('230x164')?>" alt="" />
				</a>
			</div>
			<p class="more"><a href="<?=$viewedCategory->getPath()?>">подробнее</a></p>
			<p class="price">
                <span>
                    <?=number_format($mainGood->getPriceByQuantity(1), 0, '.', ' ')?>
                </span>
                руб.
            </p>
		</div>
        <?endif?>
        <?endif?>
		<?endforeach?>
	</div>
	<?endif?>
</div>
<div class="cat_in <?= $iteration%2==0 ? 'f_right' : 'f_left'?>" itemscope itemtype="http://schema.org/Product">
	<div class="image">
		<a href="<?=$object->getPath()?>" itemprop="url"><img class="catalog-img" src="<?=$good->getFirstImage()->getFocusImage(isset($imgSize) ? $imgSize : '345x244');?>" alt="" itemprop="image" /></a>
	</div>
	<div class="desc">
		<div class="name">
			<table width="100%">
				<tbody><tr>
					<td><p class="name_in"><a href="<?=$object->getPath()?>"><?=$object->getH1()?></a></p></td>
					<meta itemprop="name" content="<?=$object->getH1()?>" />
					<td width="<?=$good->getOldPrice() ? '130' : '1'?>" style="<?=$good->getOldPrice() ?: 'border:inherit;height:38px;'?>">
						<?if($good->getOldPrice()):?>
						<p class="oldprice">Старая цена<br><span><?=number_format($good->getOldPrice(), 0, '.', ' ')?> руб</span></p>
						<p class="delta">Скидка: <?=number_format($good->getDiscount(), 0, '.', ' ')?> руб</p>
						<?endif?>
					</td>
				</tr>
			</tbody></table>
		</div>
		<div class="priced" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="priceCurrency" content="RUB"/>
			<meta itemprop="price" content="<?=number_format($good->getPriceByQuantity(1), 0, '.', '')?>"/>
			<table width="100%">
				<tbody>
					<tr>
						<td><p class="price"><span><?=number_format($good->getPriceByQuantity(1), 0, '.', ' ')?></span> руб</p>
						<p class="buyBlock">
								<a class="buy addToShopcart pointer" data-objectId="<?=$good->id?>" data-objectClass="<?=$good->getClass()?>" data-quantity="1" onclick='yaCounter22453480.reachGoal("click_kupit"); ga("send", "event", "click_kupit", "done");'>
									Купить
								</a>
						</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?if($iteration%2==0):?>
<div class="clear"></div>
<?endif?>

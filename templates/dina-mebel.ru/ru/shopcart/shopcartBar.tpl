<?if($this->getController('Shopcart')->getShopcart()->count()):?>
<div class="fix">
	<div class="foot_basket">
		<table width="100%">
			<tbody><tr>
				<td width="120"><img src="/images/bg/cart.png" alt=""> <strong>Корзина</strong></td>
				<td width="150">Товаров - <?=$this->getController('Shopcart')->getShopcart()->getTotalQuantity()?> шт.</td>
				<td width="150"><a href="/shopcart/">Перейти в корзину</a></td>
				<td><a class="reset pointer resetShopcart"><span>Очистить корзину</span></a></td>
			</tr>
		</tbody></table>
	</div>
</div>
<?else:?>
<div></div>
<?endif?>
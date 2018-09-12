<div class="placeForShopcartGoodsTable">
	<?if($this->getController('Shopcart')->getShopcart()->isGoodsInShopcart()):?>
	<?
    /*
    foreach($this->getShopcart() as $good) var_dump($good->getCategory()->credit);
    die();
    die(var_dump($this->getShopcart()));
    */
    ?>
	<div class="basket">
		<table width="100%" class="basket-table"> <!-- dobavil class="basket-table" -->
			<tbody>
				<tr>
					<th width="1">№ п/п</th>
					<th>Наименование товара</th>
					<th>Количество</th>
					<th>Цена за единицу</th>
					<th>Итоговая стоимость</th>
					<th>Удалить</th>
				</tr>
				<? $i =1; foreach($this->getShopcart() as $good):?>
				<tr class="shopcartGoodRow">
					<td><p class="num"><?=$i?></p></td>
					<td class="link-before_name"> <!-- dobavil class="link-before_name" -->
						<p class="name">
							<a href="<?=$good->getCategory()->getPath()?>" target="blank">
								<img class="shopcartGoodImage" src="<?=$good->getFirstImage()->getImage('86x65')?>" alt="">
							</a>
							<a href="<?=$good->getCategory()->getPath()?>" target="blank">
								<span class="shopcartGoodName"><?=$good->getName()?></span>
							</a>
						</p>
					</td>
					<td class="link-before_quantity"><p class="content-right"><input type="text" class="quantity" data-goodId="<?=$good->id?>" data-goodClass="<?=$good->getClass()?>" data-goodCode="<?=$good->getCode()?>" name="quantity_<?=$good->id?>" value="<?=$good->getQuantity()?>"> шт.</p></td>
					<td class="link-before_unit-price"><p class="price content-right"><span class="shopcartGoodPrice" data-shopcartGoodPrice="<?=$good->getPrice()?>"><?= number_format($good->getPrice(), 0, ',', ' ')?></span> руб</p></td>
					<td class="link-before_total-cost"><p class="price2 content-right"><span><?= number_format($good->getTotalPrice(), 0, ',', ' ')?></span> руб</p></td>
					<td><p><a class="pointer removeFromShopcart" data-goodId="<?=$good->id?>" data-goodClass="<?=$good->getClass()?>" data-goodCode="<?=$good->getCode()?>"><img src="/images/bg/del.png" alt=""></a></p></td>
				</tr>
				<? $i++; endforeach?>
				<tr>
					<td></td>
					<td class="total-price__td-none"></td> <!-- dobavil class="total-price__td-none" -->
					<td class="total-price__td-none"></td> <!-- dobavil class="total-price__td-none" -->
					<td class="bg"><p class="itog">итого:</p></td>
					<td class="bg"><p class="price2"><span><?=number_format($this->getShopcart()->getTotalPrice(), 0, ',', ' ')?></span> руб</p></td>
					<td class="total-price__td"><p><a class="resetShopcart"><img src="/images/bg/del2.png" alt=""></a></p></td>
				</tr>
			</tbody>
		</table>
	</div>

    <h1>Товары доступные в кредит</h1>
    <div class="basket">
		<table width="100%" class="basket-table"> <!-- dobavil class="basket-table" -->
			<tbody>
				<tr>
					<th width="1">№ п/п</th>
					<th>Наименование товара</th>
					<th>Количество</th>
					<th>Цена за единицу</th>
					<th>Итоговая стоимость</th>
					<th>Удалить</th>
				</tr>
				<? $i =1; foreach($this->getShopcart() as $good):?>
                <? if($good->getCategory()->credit==1):?>
				<tr class="shopcartGoodRow-credit">
					<td><p class="num"><?=$i?></p></td>
					<td class="link-before_name"> <!-- dobavil class="link-before_name" -->
						<p class="name">
							<a href="<?=$good->getCategory()->getPath()?>" target="blank">
								<img class="shopcartGoodImage" src="<?=$good->getFirstImage()->getImage('86x65')?>" alt="">
							</a>
							<a href="<?=$good->getCategory()->getPath()?>" target="blank">
								<span class="shopcartGoodName"><?=$good->getName()?></span>
							</a>
						</p>
					</td>
					<td class="link-before_quantity"><p class="content-right"><input type="text" class="quantity" data-goodId="<?=$good->id?>" data-goodClass="<?=$good->getClass()?>" data-goodCode="<?=$good->getCode()?>" name="quantity_<?=$good->id?>" value="<?=$good->getQuantity()?>"> шт.</p></td>
					<td class="link-before_unit-price"><p class="price content-right"><span class="shopcartGoodPrice" data-shopcartGoodPrice="<?=$good->getPrice()?>"><?= number_format($good->getPrice(), 0, ',', ' ')?></span> руб</p></td>
					<td class="link-before_total-cost"><p class="price2 content-right"><span><?= number_format($good->getTotalPrice(), 0, ',', ' ')?></span> руб</p></td>
					<td><p><a class="pointer removeFromShopcart" data-goodId="<?=$good->id?>" data-goodClass="<?=$good->getClass()?>" data-goodCode="<?=$good->getCode()?>"><img src="/images/bg/del.png" alt=""></a></p></td>
				</tr>
                <? $i++; endif?>
				<? endforeach?>
				<tr>
					<td></td>
					<td class="total-price__td-none"></td> <!-- dobavil class="total-price__td-none" -->
					<td class="total-price__td-none"></td> <!-- dobavil class="total-price__td-none" -->
					<td class="bg"><p class="itog">итого:</p></td>
					<td class="bg"><p class="price2"><span><?=number_format($this->getShopcart()->getTotalPriceCredit(), 0, ',', ' ')?></span> руб</p></td>
					<td class="total-price__td"><p><a class="resetShopcart"><img src="/images/bg/del2.png" alt=""></a></p></td>
				</tr>
			</tbody>
		</table>
	</div>
    
    
    
	<div class="oformlenie">
		<p class="title">Оформить заказ</p>
		<table width="100%" class="oformlenie-table"> <!-- dobavil class="oformlenie-table" -->
			<tbody class="oformlenie-table__body"> <!-- dobavil class="oformlenie-table__body" -->
				<tr class="oformlenie-table__tr-block"> <!-- dobavil class="oformlenie-table__tr-block" -->
					<td>
						<input type="text" class="inputs inputs-min-width" data-action="/order/cacheOrderData/" id="name" name="clientName" placeholder="Ф.И.О." title="Ф.И.О." value="<?=$this->getController('Order')->getCachedOrderDataByName('clientName')?>" data-errorMessage="<?=$this->getErrorsList()['clientName']?>"/>
					</td>
					<td rowspan="3" width="1">
						<textarea class="inputs inputs-min-width" data-action="/order/cacheOrderData/" id="message" name="textToSend" placeholder="Комментарий (не обязательно)" title="Комментарий (не обязательно)"><?=$this->getController('Order')->getCachedOrderDataByName('textToSend')?></textarea>
					</td>
				</tr>
				<tr class="oformlenie-table__tr-block"> <!-- dobavil class="oformlenie-table__tr-block" -->
					<td>
						<input type="text" class="inputs inputs-min-width" data-action="/order/cacheOrderData/" id="tel" name="phone" placeholder="Телефон" title="Телефон" value="<?=$this->getController('Order')->getCachedOrderDataByName('phone')?>" data-errorMessage="<?=$this->getErrorsList()['phone']?>"/>
					</td>
				</tr>
				<tr class="oformlenie-table__tr-block"> <!-- dobavil class="oformlenie-table__tr-block" -->
					<td>
						<input class="inputs inputs-min-width" data-action="/order/cacheOrderData/" type="text" id="mail" name="email" placeholder="E-mail  (не обязательно)" title="E-mail  (не обязательно)" value="<?=$this->getController('Order')->getCachedOrderDataByName('email')?>" />
					</td>
				</tr>
				<tr class="oformlenie-table__tr-block"> <!-- dobavil class="oformlenie-table__tr-block" -->
					<td>
						<span style="font-size: 14px;">Адрес доставки :</span>
					</td>
				</tr>
				<tr class="oformlenie-table__tr-flex"> <!-- dobavil class="oformlenie-table__tr-flex" -->
					<td>
						<input class="inputs inputs-min-width" data-action="/order/cacheOrderData/" type="text" id="city" name="city" placeholder="Город" title="Город" style="width: 135px;padding-left: 5px;" value="<?=$this->getController('Order')->getCachedOrderDataByName('city')?>" />
						<input class="inputs inputs-min-width" data-action="/order/cacheOrderData/" type="text" id="street" name="street" placeholder="Улица" title="Улица" style="width: 215px;float: right;margin-right: 20px;padding-left: 5px;" value="<?=$this->getController('Order')->getCachedOrderDataByName('street')?>" />
					</td>
					<td>
						<input class="inputs inputs-min-width" data-action="/order/cacheOrderData/" type="text" id="house" name="house" placeholder="Дом" title="Дом" style="width: 265px;padding-left: 5px;" value="<?=$this->getController('Order')->getCachedOrderDataByName('house')?>" />
						<input class="inputs inputs-min-width" data-action="/order/cacheOrderData/" type="text" id="apartment" name="apartment" placeholder="Квартира" title="Квартира" style="width: 265px;float: right;padding-left: 5px;" value="<?=$this->getController('Order')->getCachedOrderDataByName('apartment')?>" />
					</td>
				</tr>
				<tr class="oformlenie-table__tr-block"> <!-- dobavil class="oformlenie-table__tr-block" -->
					<td align="center"><br><button class="sendOrder">Заказать</button></td>
					<td align="center">
						<br>
						<script type="text/javascript" src="/js/shopcart/byInCredit.js?v=2018-08-20"></script>
						<button class="byInCredit">Завершить оформление кредита</button>
						<input type="hidden" name="inCreditMark" value="0">
						<input type="hidden" name="ref" value="">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?else:?>
	<div class="col_in">
		<div class="page content">
			<p>В корзине нет товаров. Перейдите на <a href="/">главную</a> страницу и выберите нужный раздел.</p>
		</div>
	</div>
	<?endif?>
</div>
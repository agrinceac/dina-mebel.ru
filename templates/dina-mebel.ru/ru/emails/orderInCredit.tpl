<? include ('header.tpl'); ?>
			<tr>
				<td colspan="2" style="padding-left: 10px;">
					<h2 class="subject" style="width: 100%;text-align: center;color: #24667B;">Новая заявка на кредит с сайта <?=SEND_FROM?></h2>
					<p>
						<br />
						Оформлена новая заявка на кредит с сайта <?=SEND_FROM?>!
						<br />
						Свяжитесь с клиентом или банком в кратчайшее время!
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding-left: 10px;">
									<strong>Данные клиента:</strong>
									<br />
									Ф.И.О.: <strong><?=$data['clientName']?></strong>
									<br />
									Телефон: <strong><?=$data['phone']?></strong>
									<br />
									<?if($data['email']):?>
									Email: <strong><?=$data['email']?></strong>
									<?endif?>
									<br />
									Адрес доставки :
									<br />
									<strong>Г. <?=$data['city']?>, ул. <?=$data['street']?>, дом <?=$data['house']?>, кв. <?=$data['apartment']?></strong>
									<br /><br />
									<?if($data['textToSend']):?>
									Текст: <strong><?=$data['textToSend']?></strong>
									<?endif?>
								</td>
							</tr>
						</table>
						<strong>Содержание заказа заявки на кредит:</strong>
						<br /><br />
						<strong>REF (идентификационный код заказа) - <?=$data['ref']?></strong>
						<br /><br />
						<table border="1" width="800" style="text-align:center;">
							<tr style="font-weight: bold;background-color: #DAE2FE;">
								<td>&nbsp;#&nbsp;</td>
								<td colspan="2">Наименование</td>
								<td>Количество</td>
								<td>Цена за единицу</td>
								<td>Цена</td>
							</tr>
							<? $i = 1; foreach ($shopcart as $good):?>
							<tr>
								<td><?=$i?></td>
								<td><a href="<?=SEND_FROM.$good->getCategory()->getPath()?>"><img src="<?=SEND_FROM.$good->getFirstImage()->getImage('100x100')?>" /></a></td>
								<td><a href="<?=SEND_FROM.$good->getCategory()->getPath()?>"><?=$good->getName()?></a></td>
								<td><?=$good->getQuantity()?></td>
								<td><?=$good->getPrice()?></td>
								<td><?=$good->getTotalPrice()?></td>
							</tr>
							<? $i++; endforeach?>
							<tr>
								<td colspan="5" style="text-align: right;"><strong>Итого:<strong></td>
								<td><strong><?=$shopcart->getTotalPrice()?></strong></td>
							</tr>
						</table>
					</p>
				</td>
			</tr>
<? include ('footerAdmin.tpl'); ?>
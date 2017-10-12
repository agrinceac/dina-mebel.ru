<? include ('headerOneClick.tpl'); ?>
	<tr>
		<td colspan="2" style="padding-left: 10px;">
			<h2 class="subject" style="width: 100%;text-align: center;color: #24667B;">Новый заказ на сайте <?=SEND_FROM?> </h2>
		</td>
	</tr>
	<tr>
		<td>
			<b style="font-size: 14px;">Выбранный товар:</b>
			<table width="150" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-size: 12px; padding: 0;">
						Название:
					</td>
					<td style="font-size: 13px; padding: 0;">
						<a href="<?=SEND_FROM?><?=$good->getPath()?>">
							<b><?=$good->getName()?></b>
						</a>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding: 0;">
						<a href="<?=SEND_FROM?><?=$good->getPath()?>">
							<img src="<?=SEND_FROM?><?=$good->getFirstImage()->getImage('150x150')?>">
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<p>
				Позвонить клиенту по номеру: <b style="font-size: 20px;"><?=$clientPhoneNumber?></b>
			</p>
			<?if($managers):?>
			Менджеры :&nbsp;&nbsp;&nbsp;&nbsp;
			<?foreach($managers as $manager):?>
			<?=$manager?>&nbsp;&nbsp;&nbsp;&nbsp;
			<?endforeach?>
			<br /><br />
			<?endif?>
		</td>
	</tr>
<? include ('footerAdmin.tpl'); ?>
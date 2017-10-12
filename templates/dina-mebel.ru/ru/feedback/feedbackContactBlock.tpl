<div class="page_form form_contact">
	<p style="font-size:17px"><strong>Вы можете задать нам вопрос прямо с сайта:</strong></p>
	<table width="100%">
		<tbody><tr>
			<td width="253"><input type="text" name='clientName' placeholder="Ф.И.О." title="Ф.И.О." style="background-image:url(/images/bg/19.png)"></td>
			<td rowspan="3" align="right"><textarea name='textToSend' placeholder="Сообщение" cols="" rows="" title="Сообщение" style="background-image:url(/images/bg/22.png)"></textarea></td>
		</tr>
		<tr>
			<td><input type="text" name="phone" placeholder="Телефон или e-mail" title="Телефон или e-mail" style="background-image:url(/images/bg/20.png)"></td>
		</tr>
		<tr>
			<td align="right">
				<img src="/images/bg/captcha.png" alt="">
				<span class="captcha"><?=$captcha?></span>
				<input type="text" class="code" name="captcha" title="Укажите результат" style="background-image:url(/images/bg/21.png)" value="">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td align="right">
				<button data-form="feedback/feedbackContactBlock">Отправить</button>
				<div class="messageSent hide"><br />Спасибо. Ваше сообщение успешно отправлено.</div>
			</td>
		</tr>
	</tbody></table>
</div><!--page_form-->
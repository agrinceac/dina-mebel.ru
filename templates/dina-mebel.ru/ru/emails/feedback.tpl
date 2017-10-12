<? include ('header.tpl'); ?>
			<tr>
				<td colspan="2" style="padding-left: 10px;">
					<h2 class="subject" style="width: 100%;text-align: center;color: #24667B;">Новый отзыв с сайта <?=SEND_FROM?></h2>
					<p>
						Здравствуйте.
						<br /><br />
						С сайта <?=SEND_FROM?> было отправлен новый отзыв.
						<br /><br />
						Данные отправителя:
						<br />
						Имя: <strong><?=$data['clientName']?></strong>
						<br />
						Телефон или e-mail: <strong><?=$data['phone']?></strong>
						<br />
						Сообщение: <strong><?=$data['textToSend']?></strong>
						<br /><br />
					</p>
				</td>
			</tr>
<? include ('footerAdmin.tpl'); ?>
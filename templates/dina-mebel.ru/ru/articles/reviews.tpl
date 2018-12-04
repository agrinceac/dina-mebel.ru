<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
		<div class="main">
			<div class="left_col">
				<?$this->includeTemplate('leftColumn')?>
			</div>
			<div class="right_col">
				<div class="col_in">
					<?$this->includeBreadcrumbs()?>
					<h1 class="page_title"><?=$article->getH1()?></h1>
					<div class="reviews">
						<?if($articles): foreach($articles as $article):?>
						<div class="review">
							<p class="date"><?=$article->date?>  |  <?=$article->name?></p>
							<?=$article->text?>
						</div>
						<?endforeach; endif?>
					</div>
					<!--<noindex>-->
					<div class="write">
						<div class="relative">
							<div class="comment_form" style="display: none; ">
								<div class="in">
									<p class="title">Написать отзыв</p>
									<p><input type="text" name="clientName" placeholder="Ваше имя" title="Ваше имя" value="" /></p>
									<p><input type="text" name="phone" placeholder="Ваш email или телефон" title="Ваш email или телефон" value="" /></p>
									<p><textarea name="textToSend" placeholder="Ваше сообщение" title="Ваше сообщение" /></textarea></p>
								</div>
								<button class="send">Отправить</button>
							</div>
						</div>
						<p class="wr_but"><a><img src="/images/bg/speech.png" alt=""> Написать отзыв</a></p>
						<p class="sendResult" style="display: none; ">
							Спасибо.<br />
							Ваш отзыв успешно отправлен администрации сайта.<br />
							После модерации он появится в списке отзывов.
						</p>
					</div>
					<!--</noindex>-->
				</div>
			</div>
			<div class="clear"></div>
		</div><!--main-->
		<div class="vote"></div>
	</div>
</div><!--root-->
<?$this->includeTemplate('footer')?>
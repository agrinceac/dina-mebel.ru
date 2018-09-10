<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
			<div class="main">

				<?=$this->getController('Catalog')->getSlyderBlock()?>

				<div class="pre_catalog">
					<p class="title">Каталог товаров</p>

					<div class="pre_catalog__container">
						<div class="cat_item " style="background-image:url(/images/del/01.jpg)">
							<div class="caption">
								<p class="name">Спальни</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог спален</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Гостиные</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/01.jpg)">
							<div class="caption">
								<p class="name line-text_normal">Мягкая мебель</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог мягкой мебели</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Кухни</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/01.jpg)">
							<div class="caption">
								<p class="name">Прихожие</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог спален</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Гостиные</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Кабинет</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Матрасы</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
						<div class="cat_item " style="background-image:url(/images/del/02.jpg)">
							<div class="caption">
								<p class="name">Дисконт</p>
								<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div><!--pre_catalog-->

				<?=$article->description?>

				<?=$this->getController('Catalog')->getHitGoodsBlock()?>

				<div class="clear"></div>

				<div itemscope itemtype="http://schema.org/Article">
					<meta itemprop="name" content="Фабрика Диа Мебель" />
					<div itemprop="description">
						<?=$article->text?>
					</div>
				</div>

			</div>
		</div>
		<div class="vote"></div>
	</div><!--root-->
<?$this->includeTemplate('footer')?>


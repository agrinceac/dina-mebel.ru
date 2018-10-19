<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
			<div class="main">

				<?=$this->getController('Catalog')->getSlyderBlock()?>

				<div class="pre_catalog">
					<p class="title">Каталог товаров</p>

					<div class="pre_catalog__container">
						<div class="cat_item">
							<a href="/spalni/">
								<div class="cat_item__img" style="background-image: url(images/del/spalni.jpg)"></div>
							</a>
							<div class="caption">
								<a href="/spalni/"><p class="name">Спальни</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог спален</a></p>-->
							</div>
						</div>
						<div class="cat_item">
							<a href="/gostinye/">
								<div class="cat_item__img" style="background-image: url(images/del/gostinie.jpg)"></div>
							</a>
							<div class="caption">
								<a href="/gostinye/"><p class="name">Гостиные</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
							</div>
						</div>
						<div class="cat_item ">
							<a href="#">
								<div class="cat_item__img" style="background-image: url(images/del/mebel.jpg)"></div>
							</a>
							<div class="caption">
								<a href=""><p class="name line-text_normal">Мягкая мебель</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог мягкой мебели</a></p>-->
							</div>
						</div>
						<div class="cat_item ">
							<a href="#">
								<div class="cat_item__img" style="background-image: url(images/del/kuhni.jpg)"></div>
							</a>
							<div class="caption">
								<a href=""><p class="name">Кухни</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
							</div>
						</div>
						<div class="cat_item">
							<a href="#">
								<div class="cat_item__img" style="background-image: url(images/del/prihojie.jpg)"></div>
							</a>
							<div class="caption">
								<a href=""><p class="name">Прихожие</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/spalni/">Посмотреть каталог спален</a></p>-->
							</div>
						</div>
						<div class="cat_item ">
							<a href="#">
								<img src="/images/del/02.jpg" alt="">
							</a>
							<div class="caption">
								<a href=""><p class="name">Детские</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
							</div>
						</div>
						<div class="cat_item ">
							<a href="#">
								<div class="cat_item__img" style="background-image: url(images/del/kabinet.jpg)"></div>
							</a>
							<div class="caption">
								<a href=""><p class="name">Кабинет</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
							</div>
						</div>
						<div class="cat_item ">
							<a href="/mATRASYI/">
								<img src="/images/del/02.jpg" alt="">
							</a>
							<div class="caption">
								<a href="/mATRASYI/"><p class="name">Матрасы</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
							</div>
						</div>
						<div class="cat_item">
							<a href="#">
								<div class="cat_item__img" style="background-image: url(images/del/discont.jpg)"></div>
							</a>
							<div class="caption">
								<a href=""><p class="name">Дисконт</p></a>
								<!--<p>Крупнейший производитель элитной корпусной мебели в России. Вот уже 11 лет наша фабрика
									радует россиян </p>
								<p class="more"><a href="/gostinye/">Посмотреть каталог гостиных</a></p>-->
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


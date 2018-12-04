<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
		<div class="main">
			<div class="left_col">
				<?$this->includeTemplate('leftColumn')?>
			</div>
			<div class="right_col">
				<div class="col_in" itemscope itemtype="http://schema.org/Product">
					<?$this->includeBreadcrumbs()?>
					<h1 class="page_title" itemprop="name"><?=$category->getH1()?></h1>
					<div class="product">
						<div class="right_product right_product-block">
							<div class="col_in">
								<div class="garantia">
									<p><img src="/images/bg/garant.png" alt=""></p>
								</div>
								<div class="boxik">
									<div class="image"><img src="/images/bg/prod_box.png" alt=""></div>
									<div class="txt">
										<p><strong>Опасайтесь подделок!</strong></p>
									</div>
									<div class="clear"></div>
									<p>Cписок наших <a href="/dillers/">официальных дилеров</a></p>
								</div>
								<div class="boxik">
									<div class="image"><img src="/images/bg/6957.png" alt=""></div>
									<div class="txt">
										<p>
											<strong>Доставка
												<br>
												<span><?= $mainGood->delivery ? $mainGood->delivery : 'Бесплатно!'?></span>
											</strong>
										</p>
									</div>
									<div class="clear"></div>
								</div>
								<div class="boxik">
									<div class="image"><img src="/images/bg/968798.png" alt=""></div>
									<div class="txt">
										<p>
											<strong>
												Сборка
												<br>
												<span><?= $mainGood->assembling ? $mainGood->assembling : 'Бесплатно!'?></span>
											</strong>
											<br>
											<em>В день доставки</em>
										</p>
									</div>
									<div class="clear"></div>
								</div>
								<div class="boxik">
									<div class="image"><img src="/images/bg/8787.png" alt=""></div>
									<div class="txt">
										<p><strong>Оплата</strong><br><em>По факту<br> VISA и MC<br> Безналичный</em></p>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div><!--right_product-->
						<div class="left_product">
							<div class="col_in">
								<div class="product_image">
									<div class="caption">
										<table class="caption-table">
											<tbody>
												<tr class="caption-table-tr">
													<td class="caption-table-td"><p><strong>Цена полного комплекта:</strong></p></td>
													<td class="caption-table-td caption-table-price"><p class="price"><span><?=number_format($mainGood->getPriceByQuantity(1), 0, '.', ' ')?></span> руб</p></td>
												</tr>
											</tbody>
										</table>
									</div>



									<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
									<script type="text/javascript" src="/js/carusel.js"></script>
                                    <script type="text/javascript" src="/js/plugins/gallery/gallery.js"></script>
                                    <script type="text/javascript" src="/js/catalog/catalogObject.js"></script>


                                    <div class="big-photo">
										<ul class="img-big-ul">
											<?$images = $mainGood->getImagesByCategoryAndStatus('1,2', 1);?>
											<? foreach($images as $image ): ?>
												<li>
													<a data-fancybox="gallery" data-href="<?=$image->getFocusImage('0x0')?>" class="bigImage">
														<img class="img-big-ul__image" src="<?=$image->getFocusImage('563x423')?>">
													</a>
												</li>
											<? endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="mini-photo">
                                        <div class="hidden-photo">
                                            <div class="touchslider-nav">
												<ul class="img-min-ul">
                                                    <? $count=2; foreach($mainGood->getImagesByCategoryAndStatus('1,2', 1) as $image ): ?>
                                                    <li>
                                                        <a class="touchslider-nav-item <?=(1==$count++)?' touchslider-nav-item-current':''?>" >
                                                            <img class="img-min-ul__image" src="<?=$image->getFocusImage('121x64')?>" style="width: 121px; height: 64px;" alt="">
                                                        </a>
                                                    </li>
                                                    <? endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <meta itemprop="priceCurrency" content="RUB"/>
                                        <meta itemprop="price" content="<?=number_format($mainGood->getPriceByQuantity(1), 0, '.', '')?>"/>
                                    </div>


								</div>
								<?$mainGood->IncrementViewsCount()?>
								<?$mainGood->SetStars();?>


								<div class="share">
									<table width="100%">
										<tbody>
											<tr>
												<td class="iconsTd">
													<p class="iconsP">Поделиться с друзьями:</p>
													<div class="share42init"></div>
													<script type="text/javascript" src="/templates/<?=core\url\UrlDecoder::getInstance()->getDomainAlias().'/'.$this->getREQUEST()['lang']?>/share42/share42.js"></script>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="pay">
									<div class="relative">
										<script type="text/javascript" src="/js/mask.js"></script>
										<script type="text/javascript" src="/js/orderByOneClick.js"></script>
										<!--<noindex>-->
										<div class="pop_up recall orderOneClickModal" style="display: none; ">
											<div class="title"><a class="close pointer">закрыть</a> <span>Обратный звонок</span></div>
											<div class="pop_in">
												<form action="/order/sendOrderByOneClick/" method="post" class="orderByOneClick">
													<table align="center" class="call-modal">
														<tbody>
															<tr>
																<td align="center"><img src="/images/bg/20.png" alt=""></td>
															</tr>
															<tr>
																<td align="center"><p>Укажите свой контактный телефон, и мы перезвоним<br> вам в ближайшие несколько минут:</p></td>
															</tr>
															<tr>
																<td align="center"><p><input type="text" id="customer_phone" placeholder="+7 (___) ___ - __ - __" name="phoneNumber" value="" /></p></td>
															</tr>
															<tr>
																<input class="oneClickGoodId" name="goodId" type="hidden" value="<?=$mainGood->id?>">
																<td align="center"><p><button class="orderByOneClickSubmit">Я жду звонка</button></p></td>
															</tr>
														</tbody>
													</table>
												</form>
												<div class="content" style="display: none;">
													<p><img src="/images/bg/20.png" alt=""></p>
													Мы благодарны вам за интерес к нашим товарам !
													<p>Наши менеджеры уже получили оповещение и в течение <span style="font-size: 20px;">10</span> минут перезвонят вам.</p>
													<p><button class="close" style="margin: 10px 0px 0px 205px">Закрыть</button></p>
												</div>
											</div>
										</div>
										<!--</noindex>-->
									</div>
									<table width="100%">
										<tbody>
											<tr class="btn-table__tr">
												<td>
													<a class="buy addToShopcart pointer"
                                                       data-objectId="<?=$mainGood->id?>"
                                                       data-objectClass="<?=$mainGood->getClass()?>"
                                                       data-quantity="1"
                                                    >
														&nbsp; Купить
													</a>
												</td>
												<td>
                                                    <a class="buy buy2 orderOneClickModalShow pointer"
                                                       data-objectId="<?=$mainGood->id?>"><img src="/images/bg/cart2.png" alt=""
                                                    >
                                                        &nbsp; Купить в один клик
                                                    </a>
                                                </td>

                                                <?if($category->credit):?>
												<td>
													<a class="buy addToShopcart pointer"
                                                       data-objectId="<?=$mainGood->id?>"
                                                       data-objectClass="<?=$mainGood->getClass()?>"
                                                       data-quantity="1"
                                                    >
														&nbsp; Купить в кредит
													</a>
												</td>
												<?endif?>

												<? if ($mainGood->instagramImgLink):?>
													<td>
													<a href="<?=$mainGood->instagramImgLink?>" target="_blank" class="link instalink">
														<img src="/images/bg/inst.png" alt="">
													</a>
													<p></p>
													</td>
												<?endif?>

											</tr>
										</tbody>
									</table>
									<? if ($mainGood->instagramImgLink): ?>
									<div class="instaCaption">
										<p>Посмотреть больше фото</p>
									</div>
									<?endif?>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div><!--product-->
					<div class="single_text content">
						<?=$mainGood->text?>
						<p></p>
						<?if($category->description):?>
						<div itemprop="description">
							<?=$category->description?>
						</div>
						<?endif?>
						<div class="clear"></div>
					</div>
					<div class="previews">
						<p class="title">Выберите нужную вам комплектацию:</p>
						<?if($objects->count()): foreach($objects as $object):?>
						<div class="preview">
							<div class="image">
								<a href="<?=$object->getFirstImage()->getImage()?>"
                                   data-fancybox="gallery"
                                   class="smallImage"
                                >
									<span class="zoom"></span>
									<img src="<?=$object->getFirstImage()->getImage('245x184')?>" alt="" />
								</a>
							</div>
							<div class="text">
								<p class="name name__center"><?=$object->getName()?></p>
								<div class="priced">
									<table width="100%">
										<tbody>
											<tr class="priced-table__tr">
												<?if($object->getPriceByQuantity(1) !=1 ):?>
												<td width="180">
													<p class="price"><span><?=number_format($object->getPriceByQuantity(1), 0, '.', ' ')?></span> руб</p>
												</td>
												<td>
													<a class="buy addToShopcart pointer" data-objectId="<?=$object->id?>" data-objectClass="<?=$object->getClass()?>" data-quantity="1">
														<img src="/images/bg/cart.png" alt=""> &nbsp; Купить
													</a>
												</td>
												<? if ($object->instagramImgLink): ?>
												<td>
													<td colspan="2"><a href="<?=$object->instagramImgLink?>" target="_blank" class="link instalink"><img src="/images/bg/inst.png" alt=""></a></td>
												</td>
												<?endif?>
												<?else:?>
												<td colspan="2">
													<p class="price">Продается только в комплекте</p>
												</td>
												<?endif?>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="text_in">
									<?=$object->description?>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<?endforeach; endif;?>
					</div>
					<?if($similarNotMainCategories->count()):?>
					<div class="catalog2">
						<p class="title">Возможно вас заинтересует:</p>
						<div class="catalog2-section">
							<?$iteration=1; foreach($similarNotMainCategories as $category):?>
							<?$this->getController('Catalog')->getCatalogObjectTemplateBlock($category, $iteration)?>
							<?$iteration++; endforeach?>
						</div>
					</div>
					<?endif?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
		</div>
		<div class="vote"></div>
	</div>
</div><!--root-->
<?$this->includeTemplate('footer')?>
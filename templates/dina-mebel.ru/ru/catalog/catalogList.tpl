<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
		<div class="main">
			<div class="left_col">
				<?$this->includeTemplate('leftColumn')?>
			</div>
			<div class="right_col">
				<div class="col_in">
					<?$this->includeBreadcrumbs()?>

                    <?if($objects && $objects->count()):?>
					<div class="sort">
						<div class="col_in">
							<?= $this->printPager($objects->getPager(), 'pager')?>
<!--							<div class="sort_item">
								<p><a href="#" class="srt">с начала новые ▼</a></p>
								<div class="white"></div>
								<div class="relative">
									<div class="sub">
										<ul>
											<li class="current"><a href="#">сначала новые</a></li>
											<li><a href="#">сначала старые</a></li>
										</ul>
									</div>
								</div>
							</div>-->
						</div>
					</div>
					<h1 class="page_title"><?= isset($title) ? $title : $category->getH1()?></h1>
					<div class="clear"></div>
                    <?endif;?>

					<?if(isset($category)):?>
					<div class="page content">
						<?=$category->text?>
					</div>
					<?endif?>
					<div class="clear"></div>

					<div class="catalog2">
						<div class="catalog2-section">
                            <?if($objects && $objects->count()):?>
							 <? $iteration=1; foreach($objects as $object):?>
							<?$this->getController('Catalog')->getCatalogObjectTemplateBlock($object, $iteration)?>
							<? $iteration++; endforeach?>
							<?else:?>
							<p>
								По вашему запросу ничего не найдено.
								Попробуйте поискать по другому запросу или перейдите на <a href="/">главную страницу</a>.
							</p>
							<?endif?>
						</div>
					</div>

                    <?if($objects && $objects->count()):?>
					<div class="sort">
						<div class="col_in">
							<?= $this->printPager($objects->getPager(), 'pager')?>
						</div>
					</div>
                    <?endif?>

			</div>

			<?if(isset($category)):?>
			<div class="page content">
				<?=$category->description?>
			</div>
			<?endif?>

			<div class="clear"></div>
		</div><!--main-->
		<div class="vote"></div>
	</div>
</div><!--root-->
<?$this->includeTemplate('footer')?>
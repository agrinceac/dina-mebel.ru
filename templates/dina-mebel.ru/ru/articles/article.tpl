<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
		<div class="main">
			<div class="left_col">
				<?$this->includeTemplate('leftColumn')?>
			</div>
			<div class="right_col">
				<div class="col_in" itemscope itemtype="http://schema.org/Article">
					<?$this->includeBreadcrumbs()?>
					<h1 class="page_title" itemprop="name"><?=$article->getH1()?></h1>
					<div class="page content" itemprop="description">
						<?=$article->text?>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div><!--main-->
		<div class="vote"></div>
	</div>
</div><!--root-->
<?$this->includeTemplate('footer')?>
<?$this->includeTemplate('meta')?>
<?$this->includeTemplate('header')?>
			<div class="main">

				<?=$this->getController('Catalog')->getSlyderBlock()?>

				<?=$article->description?>

				<?=$this->getController('Catalog')->getHitGoodsBlock()?>

				<div class="clear"></div>

                <?=$article->text?>

			</div>
		</div>
		<div class="vote"></div>
	</div><!--root-->
<?$this->includeTemplate('footer')?>


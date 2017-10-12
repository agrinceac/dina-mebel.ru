<?if($pager):?>
<div class="page_nav">
	<?if($pager->getPrevPage()):?>
	<a href="<?=$pager->getPrevPage()->getLink()?>" class="prev"></a>
	<?else:?>
	<a class="prev false"></a>
	<?endif?>

	<?if($pager->getNextPage()):?>
	<a href="<?=$pager->getNextPage()->getLink()?>" class="next"></a>
	<?else:?>
	<a class="next false"></a>
	<?endif?>

	<div class="clear"></div>
</div>

<p class="page_num">

<?if($objectsCount == 1):?>
1

<?elseif(($pager->current()->getCurrentPage() - 1) * $quantityItemsOnSubpageList + 1  == $objectsCount):?>
<?= $objectsCount?>

<?elseif($pager->current()->getCurrentPage() == 1):?>
1-<?= $quantityItemsOnSubpageList > $objectsCount ? $objectsCount : $quantityItemsOnSubpageList?>

<?elseif($pager->current()->getCurrentPage() != $pager->getTotalPages()    &&     $pager->current()->getCurrentPage() != 1):?>
<?= ($pager->current()->getCurrentPage() * $quantityItemsOnSubpageList) - $quantityItemsOnSubpageList + 1?>-<?=$pager->current()->getCurrentPage() * $quantityItemsOnSubpageList?>

<?elseif($pager->current()->getCurrentPage() == $pager->getTotalPages()):?>
<?= (($pager->getTotalPages() - 1) * $quantityItemsOnSubpageList) + 1?>-<?=$objectsCount?>

<?endif?>
 из <?=$objectsCount?>
</p>
<?endif?>
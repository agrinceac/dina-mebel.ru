<?if($objects->count()):?>
<div class="catalog">
	<p class="title">Хиты продаж:</p>
	<? $iteration=1; foreach($objects as $object):?>
	<?$this->getController('Catalog')->getCatalogObjectTemplateBlock($object->getCategory(), $iteration, '470x227')?>
	<? $iteration++; endforeach?>
</div>
<?endif?>
<br>

<? if ( !isset($objects)  ||  !$objects->count() ) : ?>
<div class="row">
    <div class="col-md-12">
        <p class="alert alert-info">
            Не найдено ни одного товара
        </p>
    </div>
</div>
<?else:?>
<div class="row sortable">
    <?$i=1; foreach($objects as $object):?>
        <?if($i==1):?>
        <input type="hidden" id="objectConfig" value="<?=get_class($object->getConfig())?>">
        <?endif?>
        <div class="col-sm-3 col-md-2 item" data-id="<?=$object->id?>" data-priority="<?=$i?>">
            <div class="thumbnail">

                <?
                    $objectWithImg = (new \modules\catalog\goods\lib\Goods())->getMainGoodByCategoryId($object->id);
                    if(!$objectWithImg)
                        $objectWithImg = (new \modules\catalog\goods\lib\Good($object->id));
                    $image = $objectWithImg->getFirstPrimaryImage();
                ?>

                <?if($image):?>
                <img src="<?=$image->getImage('230x168')?>" alt="">
                <?endif;?>

                <div class="caption">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="pull-left">
                                <?if($object->getAdminPath()):?>
                                <a href="<?=$object->getAdminPath()?>" target="_blank"><?=$object->id?></a>
                                <?else:?>
                                id = <?=$object->id?>
                                <?endif?>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="pull-right priority"><?=$i?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="pull-left"><?=$object->getValue() ? $object->getValue() :$object->getName()?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?$i++; endforeach;?>
</div>
<? endif; ?>
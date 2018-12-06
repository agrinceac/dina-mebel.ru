<?if($objects->count()):?>
    <div id="slides">
        <div class="slides_container">
            <? $i=1; foreach($objects as $object):?>

                <?
                $this->setContent('i', $i)
                    ->setContent('object', $object);
                ?>

                <?if($object->isSlyderTextNone()):?>
                    <?$this->includeTemplate('catalog/slyderBlockInner');?>
                <?elseif($object->isSlyderTextHref()):?>
                    <?
                        $this->setContent('newLocation', \core\utils\Utils::extractHrefValue($object->slyderText))
                            ->includeTemplate('catalog/slyderBlockInner')
                            ->unsetContent('newLocation');
                    ?>
                <?elseif($object->isSlyderTextEmpty()):?>
                    <?
                        $this->setContent('newLocation', $object->getCategory()->getPath())
                            ->includeTemplate('catalog/slyderBlockInner')
                            ->unsetContent('newLocation');
                    ?>
                <?else:?>
                    <?
                        $this->setContent('showSlyderTable', true)
                            ->includeTemplate('catalog/slyderBlockInner')
                            ->unsetContent('showSlyderTable');
                    ?>
                <?endif;?>

                <? $i++; endforeach?>
        </div>
    </div>
<?endif?>
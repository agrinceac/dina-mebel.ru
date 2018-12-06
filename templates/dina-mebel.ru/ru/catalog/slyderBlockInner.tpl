<div class="slide"
    <?= isset($newLocation) ? 'onclick="location.href = \'' . $newLocation . '\'"' : ''?>
    style="
        background-image:url(<?=$object->getFirstPrimaryImage()->getImage('980x0')?>);
        <?= isset($newLocation) ? 'cursor: pointer;' : ''?>
    "
>
    <?if(isset($showSlyderTable) && $showSlyderTable===true):?>
    <div class="description descriptionOfSlideNr_<?=$i?>">
        <p class="title"><?=$object->getCategory()->name?></p>
        <table width="100%">
            <tr>
                <?=$object->slyderText?>
            </tr>
            <tr>
                <td>
                    <p>
                        <a class="buy addToShopcart pointer" data-objectId="<?=$object->id?>" data-objectClass="<?=$object->getClass()?>" data-quantity="1" onclick="yaCounter22453480.reachGoal('click_kupit'); ga('send', 'event', 'click_kupit', 'done');">
                            Купить
                        </a>
                    </p>
                </td>
                <td><p class="more"><a href="<?=$object->getCategory()->getPath()?>">Подробнее о товаре</a></p></td>
            </tr>
        </table>
    </div>
    <?endif?>
</div>
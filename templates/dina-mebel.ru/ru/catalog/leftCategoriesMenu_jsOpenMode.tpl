<button type="button" class="title__burger title__burger-htx">
    <span>toggle menu</span>
</button> <!-- добавил кнопку -->
<p class="title title__btn"><img src="/images/bg/cat.png" alt=""> Каталог товаров</p>

<div class="razdel-block">
    <div class="razdel-block__btn"> <!-- добавил блок -->
        <button type="button" class="title__burger title__burger-htx">
            <span>toggle menu</span>
        </button>
    </div>
    <?if($categories): foreach($categories as $category): ?>
    <div class="razdel">

        <div class="catalog-accardion_icon">
            <p class="name category-name <?= $this->getLastElementFromRequest()==$category->alias ? 'current' : ''?>">
                <a href="<?=$category->getPath()?>"><?=$category->name?></a>
            </p>
        </div>

        <?if($category->getChildrenTypeCategory(array($activeCategoryStatus))):?>
        <ul class="razdel-menu_content <?= $category->alias?>">
            <?foreach($category->getChildrenTypeCategory(array($activeCategoryStatus)) as $child):?>
            <li>
                <p class="category-name <?= $this->getLastElementFromRequest()==$child->alias ? 'current' : ''?>" data-active=".<?=$category->alias?>">
                    &nbsp;&nbsp;&nbsp;<a href="<?=$child->getPath()?>"><?=$child->getName()?></a>
                </p>
            </li>
            <?endforeach?>
        </ul>
        <?if($child->getChildrenTypeGood(array($activeCategoryStatus))):?>
        <ul class="razdel-menu_content <?=$child->alias?>">
            <?foreach($child->getChildrenTypeGood(array($activeCategoryStatus)) as $child2):?>
                <li>
                    <p class="category-name <?= $this->getLastElementFromRequest()==$child2->alias ? 'current' : ''?>" data-active=".<?=$category->alias?>, .<?=$child->alias?>">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$child2->getPath()?>"><?=$child2->getName()?></a>
                    </p>
                </li>
            <?endforeach?>
        </ul>
        <?endif?>
        <?endif?>

        <?if($category->getChildrenTypeGood(array($activeCategoryStatus))):?>
        <ul class="razdel-menu_content <?=$category->alias?>">
            <?foreach($category->getChildrenTypeGood(array($activeCategoryStatus)) as $child):?>
                <li>
                    <p class="category-name <?= $this->getLastElementFromRequest()==$child->alias ? 'current' : ''?>" data-active=".<?=$category->alias?>">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href="<?=$child->getPath()?>"><?=$child->getName()?></a>
                    </p>
                </li>
            <?endforeach?>
        </ul>
        <?endif?>

    </div>
    <?endforeach;endif?>
</div>

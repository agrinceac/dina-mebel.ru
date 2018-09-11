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
        <p class="name category-name <?= $category->alias == $_REQUEST['action'] && !isset($_REQUEST[0]) ? 'current' : ''?>">
            <a href="<?=$category->getPath()?>"><?=$category->h1?></a>
        </p>
        <?if($category->getChildren(array($activeCategoryStatus))):?>
        <i class="catalog-accardion_icon"></i>
        <ul class="razdel-menu_content">
            <?foreach($category->getChildren(array($activeCategoryStatus)) as $child):?>
            <li
            <?= isset($_REQUEST[0]) ? ($child->alias == $_REQUEST[0] ? 'class="current"' : '') : ''?>><a
                    href="<?=$child->getPath()?>"><?=$child->getName()?></a></li>
            <?endforeach?>
        </ul>
        <?endif?>
    </div>
    <?  endforeach; endif?>
</div>

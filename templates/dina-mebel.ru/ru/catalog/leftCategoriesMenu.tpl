<button type="button" class="title__burger title__burger-htx">
    <span>toggle menu</span>
</button>
<p class="title title__btn"><img src="/images/bg/cat.png" alt=""> Каталог товаров</p>

<div class="razdel-block">
    <div class="razdel-block__btn">
        <button type="button" class="title__burger title__burger-htx">
            <span>toggle menu</span>
        </button>
    </div>
    <?if($categories): foreach($categories as $category): ?>
        <div class="razdel">

            <div class="catalog-accardion_icon
                <?= $_SERVER['REQUEST_URI']==$category->getPath() ? 'current' : ''?>"
            >
                <p class="name category-name">
                    <a href="<?=$category->getPath()?>"><?=$category->name?></a>
                </p>
            </div>

            <?if($category->getChildrenTypeCategory(array($activeCategoryStatus))):?>
                <?$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
                <ul class="razdel-menu_content"
                    style="display: <?= strpos($url, $category->getPath()) ? 'block' : ''?>"
                >
                    <?foreach($category->getChildrenTypeCategory(array($activeCategoryStatus)) as $child):?>
                        <li class="<?= strpos($url, $child->getPath()) ? 'current' : ''?>">
                            <p class="category-name">
                                &nbsp;&nbsp;<a href="<?=$child->getPath()?>"><?=$child->name?></a>
                            </p>
                        </li>
                    <?endforeach?>
                </ul>
            <?endif?>

        </div>
    <?endforeach;endif?>
</div>

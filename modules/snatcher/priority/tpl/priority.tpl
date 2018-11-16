<?include(TEMPLATES_ADMIN.'top.tpl');?>
    <div class="main single">
        <div class="max_width">
            <div class="action_buts">

            </div>
            <p class="speedbar"><a href="/admin/">Главная</a>
                <span> > </span>
                Приоритеты
            </p>
            <div class="clear"></div>

            <script src="/modules/snatcher/priority/js/priority.js"></script>

            <link rel="stylesheet" href="<?=DIR_ADMIN_HTTP?>css/bootstrap.min.css">
            <link rel="stylesheet" href="/modules/snatcher/priority/css/sorting.css">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formFilters" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="domainAlias" id="domainAlias" style="width: 100%;">
                                        <option value="">Домен</option>
                                        <? foreach ( $domainAliasesArray as $domainAlias ): ?>
                                            <option
                                                <?= $this->getGET()['domainAlias']==$domainAlias?'selected':''?>
                                                value="<?=$domainAlias?>"
                                            >
                                                <?=$domainAlias?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="selectionAlias" id="selectionAlias" style="width: 100%;">
                                        <option value="">Выборка</option>
                                        <? foreach ( $selectionAliasesArray as $selectionAlias => $selection ): ?>
                                            <option <?= $this->getGET()['selectionAlias']==$selectionAlias?'selected':''?> value="<?=$selectionAlias?>"><?=$selection['title']?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input name="url" id="url" placeholder="Адрес страницы" value="<?= $this->getGET()['url']?$this->getGET()['url']:''?>" style="width: 300%;" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 itemsContainer">
                        <?include 'list.tpl'?>
                    </div>
                </div>
            </div>

        </div>
    </div><!--main-->
    <div class="vote"></div>
    </div><!--root-->
<?include(TEMPLATES_ADMIN.'footer.tpl');?>
<body>
<!-- Google Tag Manager -->
<noscript>
    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-M8346S"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<script>(function (w, d, s, l, i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window, document, 'script', 'dataLayer', 'GTM-M8346S');</script>
<!-- End Google Tag Manager -->
<div class="root">
    <div class="max_width">
        <div class="head">
            <div class="logo">
                <p><a class="logoImage" href="/"><img class="logoPic" src="/images/bg/logo.svg" alt=""/></a></p>
            </div><!--logo-->
            <div class="right_head">
                <div class="col_in">
                    <div class="head_contact">

                        <div class="showroom-menu-item">
                            <img src="/images/bg/chair.svg" alt=""/><span>Шоу-рум</span>
                            <br/>
                            <a href="/showroom/">Подробнее</a>
                        </div>

                        <div class="meta__block" itemscope itemtype="http://schema.org/Organization">
                            <meta itemprop="name" content="Мебельная фабрика Диа Мебель в Калининграде"/>
                            <meta itemprop="logo" content="http://dia-mebel.ru/images/bg/logo.png"/>
                            <meta itemprop="telephone" content="+7 (495) 773-23-11"/>
                            <meta itemprop="email" content="sale@dia-mebel.ru"/>
                            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <meta itemprop="streetAddress" content="ул. Жуковского, стр. 27"/>
                                <meta itemprop="postalCode" content="141400"/>
                                <meta itemprop="addressLocality" content="Москва"/>
                            </div>
                        </div>

                        <table align="right" class="header-table">
                            <tr class="header-table__tr">
                                <?=$this->getController('Article')->getArticle('schedule')->text?>
                            </tr>
                        </table>

                    </div>
                </div>
            </div><!--right_head-->
            <div class="clear"></div>
        </div><!--head-->
        <div class="menu">
            <button type="button" class="button-menu_mobil button-menu_mobil-htx">
                <span>toggle menu</span>
            </button> <!-- добавил кнопку -->
            <div class="search search_block">
                <form action="/search/" method="get" id="searchHeaderForm">
                    <div class="search_in">
                        <input type="text" value="<?= isset($this->getGET()['query']) ? $this->getGET()['query'] : ''?>"
                               name="query" placeholder="Поиск по каталогу" title="Поиск по каталогу"/>
                        <button class="search"
                                onClick="if(($.trim( $('[name=query]').val()))=='') {return false;} else {$('#searchHeaderForm').submit();}">
                            &nbsp;
                        </button>
                    </div>
                </form>
            </div>
            <?=$this->getController('Article')->getTopMenu()?>
            <div class="clear"></div>
        </div><!--menu-->
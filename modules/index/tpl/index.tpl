<?include(TEMPLATES_ADMIN.'top.tpl');?>
        <div class="main">
        	<div class="max_width">
            	<div class="list">
			<div class="col_in">
				<?if($this->getController('Goods')->getLastGoods(5)):?>
				<div class="list_item active">
					<p class="title"><span>&#9660;</span> Последние 5 добавленных товаров</p>
					<table width="100%">
						<tr>
							<th class="first">id</th>
							<th>название</th>
							<th>код</th>
						</tr>
						<?//foreach($this->getController('Goods')->getLastGoods(5) as $item):?>
						<tr>
							<td><?//=$item->id?></td>
							<td><a href="/admin/goods/good/<?//=$item->id?>/"><?//=$item->getName()?></a></td>
							<td><?//=$item->getCode()?></td>
						</tr>
						<?//endforeach?>
					</table>
				</div>
				<?endif?>
			</div>
		</div><!--list-->

                <div class="action">
			<?if($this->checkUserRight('article_add')):?>
			<div class="box">
				<a href="/admin/articles/article/"><img src="/admin/images/buttons/add_article.png" alt="" /><span>Добавить статью</span></a>
			</div>
			<?endif?>
			<?if($this->checkUserRight('good_add')):?>
			<div class="box">
				<a href="/admin/goods/good/"><img src="/admin/images/buttons/add_project.png" alt="" /><span>Добавить товар</span></a>
			</div>
			<?endif?>
			<?if($this->checkUserRight('articles')):?>
			<div class="box">
				<a href="/admin/articles/"><img src="/admin/images/buttons/edit_articles.png" alt="" /><span>Редактировать <br />статьи</span></a>
			</div>
			<?endif?>
			<?if($this->checkUserRight('goods')):?>
			<div class="box">
				<a href="/admin/goods/"><img src="/admin/images/buttons/edit_projects.png" alt="" /><span>Редактировать <br />товары</span></a>
			</div>
			<?endif?>
			<?if($this->checkUserRight('settings')):?>
			<div class="box">
			<a href="/admin/settings/"><img src="/admin/images/buttons/edit_settings.png" alt="" /><span>Настройки</span></a>
			</div>
			<?endif?>
                </div>
                <div class="clear"></div>
            </div>
        </div><!--main-->

        <div class="vote"></div>
    </div><!--root-->
<?include(TEMPLATES_ADMIN.'footer.tpl');?>
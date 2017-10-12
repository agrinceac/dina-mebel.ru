<?include(TEMPLATES_ADMIN.'top.tpl');?>
		<script type="text/javascript" src="/js/ajaxLoader.class.js"></script>
		<div class="main single">
			<div class="max_width">
				<div class="action_buts">
					<?if( ! $this->isAuthorisatedUserAnManager()):?>
					<a class="form<?= $object->id ? 'Edit' : 'Add'?>Submit pointer" ><img src="/admin/images/buttons/save_object.png" alt="" /> Сохранить</a>
					<? if ($object->id):?>
						<a class="button confirm pointer" data-confirm= "Remove the good?" data-action="/admin/goods/remove/<?=$object->id?>/"
							data-callback="postRemoveFromDetails" data-post-action="/admin/goods/" >
							<img src="/admin/images/buttons/delete.png" alt="" /> Удалить
						</a>
					<? endif;?>
					<?endif?>
					<a href="/admin/goods/"><img src="/admin/images/buttons/back.png" alt="" /> Вернуться</a>
				</div>
				<p class="speedbar">
					<a href="/admin/">Главная</a><span> > </span>
					<a href="/admin/goods/">Товары</a><span> > </span>
					<?= $object->id ? 'Редактирование' : 'Добавление'?>
				</p>
				<div class="clear"></div>
				<div class="sitebar">
                    <div class="clear"></div><!--end clear-->
                </div><!--end sitebar-->
				<div id="contentBlock">
<?$this->getMainContentBlock($object->id)?>
				</div>
			</div>
		</div><!--main-->
		<div class="vote"></div>
	</div><!--root-->
    <?include(TEMPLATES_ADMIN.'footer.tpl');?>
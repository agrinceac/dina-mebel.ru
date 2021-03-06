<?include(TEMPLATES_ADMIN.'top.tpl');?>
		<script type="text/javascript" src="/admin/js/base/system/sorting.js"></script>
		<script type="text/javascript" src="/admin/js/base/system/groupActions.js"></script>
		<div class="main single">
			<div class="max_width">
				<div class="action_buts">
					<a href="/admin/articles/category/"><img src="/admin/images/buttons/add.png" alt="" /> Создать</a>
					<a class="filters pointer"><img src="/admin/images/buttons/search.png" alt="" /> Фильтрация</a>
				</div>
				<p class="speedbar">
					<a href="/admin/">Главная</a>     <span>></span>
					<a href="/admin/articles/">Статьи</a>     <span>></span>
					Категории
				</p>
				<div class="clear"></div>
				<!-- Start: Filetrs Block -->
				<div id="filter-form"  style="<?=(isset($_REQUEST['form_in_use'])?'display:block;':'display:none;')?>">
					<form id="search" action="" method="get">
						<input type="hidden" name="form_in_use" value="true" />
						<table>
							<tr>
								<td class="right">Родитель:</td>
								<td>
									<select class="filterInput" name="parentCategoryId">
										<option></option>
										<?php if ($objects->getMainCategories()->count()): foreach($objects->getMainCategories() as $categoryObject):?>
										<option value="<?=$categoryObject->id?>" <?=($categoryObject->id==$this->getGET()['parentCategoryId']) ? 'selected' : ''; ?>><?=$categoryObject->name?></option>
											<?php if ($categoryObject->getChildren()): foreach($categoryObject->getChildren() as $children):?>
											<option value="<?=$children->id?>" <?=($children->id==$this->getGET()['parentCategoryId']) ? 'selected' : ''; ?>>&nbsp;&nbsp;|-&nbsp;<?=$children->name?></option>
												<?php if ($children->getChildren() != NULL): foreach($children->getChildren() as $children2):?>
												<option value="<?=$children2->id?>" <?=($children2->id==$this->getGET()['parentCategoryId']) ? 'selected' : ''; ?>>&nbsp;&nbsp;&nbsp;&nbsp;|-&nbsp;<?=$children2->name?></option>
												<?php endforeach; endif;?>
											<?php endforeach; endif;?>
										<?php endforeach; endif;?>
									</select>
								</td>
								<td class="right">Статус:</td>
								<td><select class="filterInput" name="statusId">
										<option value="">&nbsp;</option>
										<?php foreach ($objects->getStatuses() as $status):?>
										<option value="<?=$status->id?>" <?=($this->getGET()['statusId']==$status->id)?'selected':''?>><?=$status->name?></option>
										<?php endforeach;?>
									</select>
								</td>
								<td class="right">ID:</td>
								<td><input class="filterInput" type="text" name="id" value="<?=$this->getGET()['id']?>" /></td>
								<td class="right">Алиас:</td>
								<td><input class="filterInput" type="text" name="alias" value="<?=$this->getGET()['alias']?>" /></td>
							</tr>
							<tr>
								<td class="right">Название:</td>
								<td><input class="filterInput" type="text" name="name" value="<?=$this->getGET()['name']?>" /></td>
							</tr>
							<tr>
								<td colspan="8">
									<div class="action_buts">
										<a class="pointer" onclick="$('#search').submit()"><img src="/admin/images/buttons/search.png" /> Поиск</a>
										<a class="resetFilters" href="/admin/<?=$_REQUEST['controller']?>/categories/"><img src="/admin/images/buttons/delete.png" /> Сбросить фильтры</a>
									</div>
								</td>
							<tr>
						</table>
					</form>
				</div>
				<!-- End: Filters Block -->
				<div class="table_edit">
					<?if(count($categories) == 0): echo 'No Data'; else:?>
					<table  id="objects-tbl" data-sortUrlAction="/admin/articles/changeCategoriesPriority/?" width="100%">
						<tr>
							<th colspan="2" class="first">ID</th>
							<th>Алиас</th>
							<th>Название</th>
							<th>Домен</th>
							<th>Дата</th>
							<th>Статус</th>
							<th class="last" colspan="4">Приоритет</th>
						</tr>
						<?foreach ($categories as $category):?>
							<tr id="id<?=$category->id?>" class="dblclick ui-selectee" data-url="/admin/articles/category/<?=$category->id?>" data-id="<?=$category->id?>" data-priority="<?=$category->priority?>">
								<td><input type="checkbox" class="groupElements" /></td>
								<td><?=$category->id?></td>
								<td><p class="alias"><a href="/admin/articles/category/<?=$category->id?>"><?=$category->alias?></a></p></td>
								<td><p class="name"><?=$category->name?></p></td>
								<td><p class="name"><?=$category->domainAlias?></p></td>
								<td><p class="date"><?=$category->date?></p></td>
								<td><p class="status"><font color="<?=$category->getStatus()->color?>"><?=$category->getStatus()->name?></font></p></td>
								<td class="td_bord sortHandle header"><?= $category->priority?></td>
								<td><a href="/admin/articles/category/<?=$category->id?>" class="pen"></a></td>
								<td><a class="del pointer button confirm" data-confirm="Remove the category?" data-action="/admin/articles/removeCategory/<?=$category->id?>/" data-callback="postRemoveCategory"></a></td>
							</tr>
						<?endforeach?>
					</table>
					<?endif?>
				</div>

<!--				<div class="action_edit">
					<table>
						<tr>
							<td><a href="javascript:" class="check_all"><span>Выделить все</span></a></td>
							<td>
								<select>
									<option>С выделенными</option>
								</select>
							</td>
							<td></td>
						</tr>
					</table>
				</div>-->
			</div>
		</div><!--main-->
		<div class="vote"></div>
	</div><!--root-->
<?include(TEMPLATES_ADMIN.'footer.tpl');?>
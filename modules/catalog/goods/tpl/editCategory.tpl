<div class="main_edit">
	<div class="main_param">
		<div class="col_in">
			<table width="100%">
				<tr>
					<td colspan="2"><p class="title">Основные параметры:</p></td>
				</tr>
				<tr>
					<td class="first">Имя:</td>
					<td><input type="text" name="name" value="<?=$object->name?>" /></td>
				</tr>
				<tr>
					<td class="first">H1:</td>
					<td><input type="text" name="h1" value="<?=$object->h1?>" /></td>
				</tr>
				<tr>
					<td class="first">Родительская категория:</td>
					<td>
						<select name="parentId" style="width:150px;">
							<option></option>
							<?php if ($mainCategoriesTypeCategory->count()): foreach($mainCategories as $categoryObject):?>
							<option value="<?=$categoryObject->id?>" <?=($categoryObject->id==$object->parentId) ? 'selected' : ''; ?>><?=$categoryObject->name?></option>
								<?php if ($categoryObject->getChildrenTypeCategory()): foreach($categoryObject->getChildrenTypeCategory() as $children):?>
								<option value="<?=$children->id?>" <?=($children->id==$object->parentId) ? 'selected' : ''; ?>>&nbsp;&nbsp;|-&nbsp;<?=$children->name?></option>
									<?php if ($children->getChildrenTypeCategory()): foreach($children->getChildrenTypeCategory() as $children2):?>
									<option value="<?=$children2->id?>" <?=($children2->id==$object->parentId) ? 'selected' : ''; ?>>&nbsp;&nbsp;&nbsp;&nbsp;|-&nbsp;<?=$children2->name?></option>
									<?php endforeach; endif;?>
								<?php endforeach; endif;?>
							<?php endforeach; endif;?>
						</select>
					</td>
				</tr>
                <tr>
                    <td class="first">Дополнительная<br>родительская категория:</td>
                    <td>

                        <script type="text/javascript" src="/modules/catalog/js/additionalCategories.js"></script>
                        <script type="text/javascript" src="/admin/js/jquery/multi-select/multi-select.js"></script>
                        <link rel="stylesheet" type="text/css" href="/admin/js/jquery/multi-select/multi-select.css" />

                        <select name="additionalParents[]" multiple="multiple" class="additionalCategories" style="width:150px;">
                            <?if($mainCategoriesTypeCategory->count()): foreach($mainCategoriesTypeCategory as $categoryObject):?>
                                <optgroup label="<?=$categoryObject->name?>">
                                    <?php if ($categoryObject->getChildrenTypeCategory()): foreach($categoryObject->getChildrenTypeCategory() as $children):?>
                                        <option value="<?=$children->id?>" <?=   isset($object->id)   ?   (in_array($children->id, $object->additionalParentsArray)) ? 'selected' : ''   :    '' ?>><?=$children->name?></option>
                                        <?php if ($children->getChildrenTypeCategory()): foreach($children->getChildrenTypeCategory() as $children2):?>
                                            <option value="<?=$children2->id?>" <?=   isset($object->id)   ?   (in_array($children->id, $object->additionalParentsArray)) ? 'selected' : ''   :    '' ?>>&nbsp;&nbsp;|-&nbsp;<?=$children2->name?></option>
                                        <?php endforeach; endif;?>
                                    <?php endforeach; endif;?>
                                </optgroup>
                            <?php endforeach; endif;?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td class="first">Тип:</td>
                    <td>
                        <select name="type" style="width:150px;">
                            <?foreach((new \core\modules\categories\CategoryConfig())->getCatalogTypesArray() as $type):?>
                            <option value="<?=$type['alias']?>" <?= $object->type==$type['alias'] ? 'selected' : ''?>><?=$type['name']?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
                <?if($object->parentId):?>
                <tr>
                    <td class="first">Доступен кредит:</td>
                    <td><input style="width:20px;height:20px" type="checkbox" name="credit" value="1" <?=$object->credit?'checked':'';?> /></td>
                </tr>
                <?endif?>
				<tr>
					<td class="first">Описание:</td>
					<td><textarea name="description" cols="95" rows="10"><?=$object->description?></textarea>
				</tr>
				<tr>
					<td class="first">Текст:</td>
					<td><textarea name="text" cols="95" rows="10"><?=$object->text?></textarea>
				</tr>
				<tr>
					<td colspan="2"><p class="title">Мета данные:</p></td>
				</tr>
				<tr>
					<td class="first">Meta Title:</td>
					<td><input name="metaTitle" value="<?=$object->metaTitle?>" type="text"/></td>
				</tr>
				<tr>
					<td class="first">Meta Keywords:</td>
					<td><input name="metaKeywords" value="<?=$object->metaKeywords?>" type="text"/></td>
				</tr>
				<tr>
					<td class="first">Meta Description:</td>
					<td><input name="metaDescription" value="<?=$object->metaDescription?>" type="text"/></td>
				</tr>
			</table>
		</div>
	</div><!--main_param-->
	<div class="dop_param">
		<div class="col_in">
			<p class="title">Дополнительные параметры:</p>
			<table width="100%">
				<tr>
					<td class="first">Alias:</td>
					<td>
						<input type="hidden" name="id" value="<?=$object->id?>" />
						<input size="20" name="alias" value="<?=$object->alias?>"/>
					</td>
				</tr>
				<tr>
					<td class="first">Status:</td>
					<td>
						<select name="statusId" style="width:150px;">
							<?if ($statuses): foreach($statuses as $status):?>
							<option value="<?=$status->id?>" <?= $status->id==$object->statusId ? 'selected' : ''?>><?=$status->name?></option>
							<?endforeach; endif?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="first">Дата:</td>
					<td><input class="date" name="date" title="Date" value="<?=$object->date?>"/></td>
				</tr>
				<tr>
					<td class="first">Приоритет:</td>
					<td><input name="priority" value="<?=$object->priority; ?>" /></td>
				</tr>
<!--				<tr>
					<td class="first">Шаблон:</td>
					<td><?=$object->template; ?></td>
				</tr>-->
			</table>

		</div>
	</div><!--dop_param-->
	<div class="clear"></div>
</div><!--main_edit-->
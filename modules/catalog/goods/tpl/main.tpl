						<script type="text/javascript" src="/admin/js/base/system/tabs.js"></script>
						<?if ($object->id):?><input type="hidden" value="<?=$object->id?>" id="objectId"/><?endif;?>
						<div id="tabs">
							<div class="tab_page">
								<ul>
									<li>
										<a href="#main">Параметры</a>
									</li>
								</ul>
							</div>
							<div id="main">
							    <input type='hidden' class='objectId' value='<?=$object->id?>'>
								<form class="form<?= $object->id ? 'Edit' : 'Add'?>" action="/admin/goods/<?= $object->id ? 'edit' : 'add'?>/" method="post" data-post-action="<?= $object->id ? 'none' : '/admin/goods/good/'?>">
									<?if ($object->id):?><input type="hidden" name="id" value="<?=$object->id?>"/><?endif;?>
									<div class="main_edit">
										<div class="main_param">
											<div class="col_in">
												<p class="title">Основные параметры:</p>
												<table width="100%">
													<tr>
														<td class="first">Название:</td>
														<td><input type="text" name="name" value="<?=$object->getName()?>" /></td>
													</tr>
													<tr>
														<td class="first">Цена:</td>
														<td><input style="width: 100px" type="text" name="price" value="<?=$object->price?>" /></td>
													</tr>
													<tr>
														<td class="first">Старая цена:</td>
														<td><input style="width: 100px" type="text" name="oldPrice" value="<?=$object->oldPrice?>" /></td>
													</tr>
													<tr>
														<td class="first">Доставка:</td>
														<td><input style="width: 200px" type="text" name="delivery" value="<?=$object->delivery?>" /></td>
													</tr>
													<tr>
														<td class="first">Сборка:</td>
														<td><input style="width: 200px" type="text" name="assembling" value="<?=$object->assembling?>" /></td>
													</tr>
													<tr>
														<td class="first">Рейтинг:</td>
														<td>
															<select name="stars" style="width: 40px;">
																<option></option>
																<?for($i=1; $i <= 5; $i++):?>
																<option value="<?=$i?>" <?= $object->stars == $i ? 'selected' : ''?>><?=$i?></option>
																<?endfor?>
															</select>
															 (для основных товаров категории)
														</td>
													</tr>

													<tr>
														<td class="first">Описание:</td>
														<td><textarea name="description" cols="95" rows="20" style="height: 100px;"><?=$object->description?></textarea>
													</tr>

													<tr>
														<td class="first">Текст акции:</td>
														<td><textarea name="text" cols="95" rows="20" style="height: 100px;"><?=$object->text?></textarea>
													</tr>

													<tr>
														<td class="first">Текст слайдера:</td>
														<td><textarea name="slyderText" cols="95" rows="20" style="height: 100px;"><?=$object->slyderText?></textarea>
													</tr>
													
													<tr>
														<td class="first">Картинка на инстаграм:</td>
														<td><input type="text" name="instagramImgLink" value="<?=$object->instagramImgLink?>" /></td>
													</tr>
												</table>
											</div>
										</div><!--main_param-->
										<div class="dop_param">
											<div class="col_in">
												<p class="title">Дополнительные параметры:</p>
												<table width="100%">
													<tr style="display: none;">
														<td class="first">Код:</td>
														<td><input name="code" value="1" /></td>
													</tr>
													<tr>
														<td class="first">Статус:</td>
														<td>
															<select name="statusId" style="width:150px;">
																<?if ($objects->getStatuses()): foreach($objects->getStatuses() as $status):?>
																<option value="<?=$status->id?>" style="color:<?=$status->color?>; font-weight:bold;" <?= $status->id==$object->statusId ? 'selected' : ''?>><?=$status->name?></option>
																<?endforeach; endif?>
															</select>
														</td>
													</tr>
													<tr>
														<td class="first">Категория:</td>
														<td>
															<select name="categoryId" style="width:150px;">
															<option></option>
															<?if ($objects->getMainCategories()->count()): foreach($objects->getMainCategories() as $categoryObject):?>
															<option value="<?=$categoryObject->id?>" <?=($categoryObject->id==$object->categoryId) ? 'selected' : ''; ?>><?=$categoryObject->name?></option>
																<?php if ($categoryObject->getChildren()): foreach($categoryObject->getChildren() as $children):?>
																<option value="<?=$children->id?>" <?=($children->id==$object->categoryId) ? 'selected' : ''; ?>>&nbsp;&nbsp;|-&nbsp;<?=$children->name?></option>
																	<?php if ($children->getChildren()): foreach($children->getChildren() as $children2):?>
																	<option value="<?=$children2->id?>" <?=($children2->id==$object->categoryId) ? 'selected' : ''; ?>>&nbsp;&nbsp;&nbsp;&nbsp;|-&nbsp;<?=$children2->name?></option>
																	<?php endforeach; endif;?>
																<?php endforeach; endif;?>
															<?php endforeach; endif;?>
															</select>
														</td>
													</tr>

                                                    <script type="text/javascript" src="/modules/catalog/js/additionalCategories.js"></script>
                                                    <script type="text/javascript" src="/admin/js/jquery/multi-select/multi-select.js"></script>
                                                    <link rel="stylesheet" type="text/css" href="/admin/js/jquery/multi-select/multi-select.css" />
                                                    <tr>
                                                        <td class="first">Дополнительные<br>категории:</td>
                                                        <td>
                                                            <br>
                                                            <select name="additionalCategories[]" multiple="multiple" class="additionalCategories" style="width:150px;">
                                                                <?if ($objects->getMainCategories()->count()): foreach($objects->getMainCategories() as $categoryObject):?>
                                                                    <optgroup label="<?=$categoryObject->name?>">
                                                                        <?php if ($categoryObject->getChildren()): foreach($categoryObject->getChildren() as $children):?>
                                                                            <option value="<?=$children->id?>" <?=   isset($object->id)   ?   (in_array($children->id, $object->additionalCategoriesArray)) ? 'selected' : ''   :    '' ?>><?=$children->name?></option>
                                                                            <?php if ($children->getChildren()): foreach($children->getChildren() as $children2):?>
                                                                                <option value="<?=$children2->id?>" <?=   isset($object->id)   ?   (in_array($children->id, $object->additionalCategoriesArray)) ? 'selected' : ''   :    '' ?>>&nbsp;&nbsp;|-&nbsp;<?=$children2->name?></option>
                                                                            <?php endforeach; endif;?>
                                                                        <?php endforeach; endif;?>
                                                                    </optgroup>
                                                                <?php endforeach; endif;?>
                                                            </select>
                                                        </td>
                                                    </tr>

													<tr>
														<td class="first">В слайдере:</td>
														<td><input style="width:20px;height:20px" type="checkbox" name="slyder" value="1" <?=$object->slyder?'checked':'';?> /></td>
													</tr>
													<tr>
														<td class="first">Дата:</td>
														<td><input class="date" name="date" title="Date" value="<?=$object->date?>"/></td>
													</tr>
													<tr>
														<td class="first">Приоритет:</td>
														<td><input name="priority" value="<?=$object->priority; ?>" /></td>
													</tr>
													<tr>
														<td class="first">Алиас:</td>
														<td><input name="alias" value="<?=$object->alias; ?>" /></td>
													</tr>
												</table>

												<p class="title">Sitemap XML:</p>
												<table width="100%">
													<tr>
														<td class="first">Посл. обновление:</td>
														<td>
															<input class="date" name="lastUpdateTime" title="Время последнего обновления" value="<?= \core\utils\Dates::toSimpleDate( \core\utils\Dates::dateTimeToTimestamp($object->getLastUpdateTime()) )?>"/>
														</td>
													</tr>
													<tr>
														<td class="first">Приоритет:</td>
														<td>
															<select name="sitemapPriority">
<?foreach (\core\seo\sitemap\SitemapValues::getPriorityValues() as $value):?>
																<option value="<?=$value?>" <?=($object->getSitemapPriority() == $value) ? 'selected' : ''?>><?=$value?></option>
<?endforeach;?>
															</select>
														</td>
													</tr>
													<tr>
														<td class="first">Частота обновлений:</td>
														<td>
															<select name="changeFreq">
<?foreach (\core\seo\sitemap\SitemapValues::getChangeFreqValues() as $key => $value):?>
																<option value="<?=$key?>" <?=($object->getChangeFreq() == $key) ? 'selected' : ''?>><?=$value?></option>
<?endforeach;?>
															</select>
														</td>
													</tr>
												</table>
											</div>
										</div><!--dop_param-->
										<?$this->includeTemplate('images')?>
										<div class="clear"></div>
									</div><!--main_edit-->
								</form>
							</div><!--main-->
						</div>
					</form>
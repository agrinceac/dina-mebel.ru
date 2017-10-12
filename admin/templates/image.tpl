				<div id="imageDetails" class="imagesForm">
					<form class="formImageEdit" action="/admin/<?=$this->getREQUEST()['controller']?>/editImage/<?=$image->id?>/">
						<input type="hidden" name="name" value="<?=$image->name?>">
						<table>
							<tr>
								<td class="image">
									<a href="<?=$image->getImage('800x600')?>" class="lightbox">
										<img src="<?=$image->getImage('400x300')?>" />
									</a>
								</td>
								<td>
									<table>
										<tr>
											<td class="title"><span>Title:</span> </td>
											<td class="title"><input type="text" name="title" value="<?=$image->title?>"/></td>
										</tr>
										<tr>
											<td class="alias"><span>Alias:</span> </td>
											<td class="alias"><input type="text" name="alias" value="<?=$image->alias?>"/></td>
										</tr>
										<tr>
											<td class="status"><span>Status:</span></td>
											<td class="status">
												<select name="statusId">
													<? foreach( $objects->getImagesStatuses() as $status ): ?>
														<option value="<?=$status->id?>" <?=($status->id==$image->getStatus()->id)?'selected':''?>><?=$status->name?></option>
													<? endforeach; ?>
												</select>
											</td>
										</tr>
<!--										<tr>
											<td class="priority"><span>Priority:</span></td>
											<td class="priority"><input type="text" name="priority" value="<?=$image->priority?>"/></td>
										</tr>-->
										<tr>
											<td class="category">
												<span>Category:</span>
											</td>
											<td class="category">
												<select name="categoryId">
													<? foreach( $objects->getImagesCategories() as $category ): ?>
														<option value="<?=$category->id?>" <?=($category->id==$image->getCategory()->id)?'selected':''?>><?=$category->name?></option>
													<? endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2" class="description">
												<span style="display: block;">Description:</span>
												<textarea name="description"><?=$image->description?></textarea>
											</td>
										</tr>
										<tr>
											<td class="title"><span>Path:</span> </td>
											<td class="title"><?=$imageRealSizePath?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" class="remove">
									<a
										href="#remove"
										class="removeImageFromDetails confirm hide"
										data-confirm="Remove image?"
										data-action="/admin/<?=$this->getREQUEST()['controller']?>/removeImage/<?=$image->id?>/"
									>
										remove
									</a>
								</td>
							</tr>
							<tr>
								<td colspan="4" class="edit">
									<a
										href="#edit"
										class="formImageEditSubmit hide"
									>
										edit
									</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
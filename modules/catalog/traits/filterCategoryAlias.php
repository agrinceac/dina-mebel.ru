<?php
namespace modules\catalog\traits;
trait filterCategoryAlias {
	public function setFiltersByCategoryAlias($categoryAlias)
	{
		$query = '
			AND
				(`categoryId` =
					(SELECT
						`id`
					FROM
						`'.$this->getCategories()->mainTable().'`
					WHERE
						`alias` = "?s"
					LIMIT 1
					)
					OR
				`categoryId` IN
					(SELECT
						`id`
					FROM
						`'.$this->getCategories()->mainTable().'`
					WHERE
						`parentId` = (SELECT
								`id`
							FROM
								`'.$this->getCategories()->mainTable().'`
							WHERE
								`alias` = "?s"
							LIMIT 1
							)
					)
					OR
				`id` IN
					(SELECT
						`ownerId`
					FROM
						`'.$this->mainTable().'_additionalCategories`
					WHERE
						`objectId` IN (SELECT
							`id`
						FROM
							`'.$this->getCategories()->mainTable().'`
						WHERE
							`alias` = "?s"
						)
					)
				)';
		$this->setSubquery($query, $categoryAlias, $categoryAlias, $categoryAlias);
		return $this;
	}
}
<?php
namespace modules\catalog\goods\lib;
use core\modules\categories\AdditionalCategoriesConfig;

class Goods extends \core\modules\base\ModuleDecorator implements \Countable
{
	use \modules\catalog\traits\filterCategoryAlias;

	function __construct()
	{
		$object = new GoodsObject();
		$object = new \core\modules\images\ImagesDecorator($object);
		$object = new \core\modules\statuses\StatusesDecorator($object);
		$object = new \core\modules\categories\CategoriesDecorator($object);
		parent::__construct($object);
	}

	/* Start: Countable Methods */
	public function count()
	{
		return $this->getParentObject()->count();
	}
	/* End: Countable Methods */

    public function getMainGoodByCategoryId($categoryId)
    {
        $this->resetFilters();
        $this->setSubquery('AND 
                (   `categoryId` =  ?d 
                        OR
                    `id` IN (SELECT `ownerId` FROM 
                    `'.$this->getObjectConfig()->mainTable().(new AdditionalCategoriesConfig())->getTablePostfix().'`
                     WHERE `objectId` = ?d)
                )'
            , $categoryId, $categoryId
        )
            ->setOrderBy('`priority` ASC, `id` ASC')
            ->setLimit(1);
        return $this->current();
    }
}

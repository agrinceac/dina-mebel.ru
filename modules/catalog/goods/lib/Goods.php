<?php
namespace modules\catalog\goods\lib;
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
        $this->setSubquery('AND `categoryId` =  ?d ', $categoryId)
            ->setOrderBy('`priority` ASC, `id` ASC')
            ->setLimit(1);
        return $this->current();
    }
}

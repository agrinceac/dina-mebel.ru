<?php
namespace core\modules\categories;
use modules\catalog\goods\lib\GoodConfig;

class AdditionalParents extends \core\modules\base\ModuleDecorator
{
	function __construct($objectId)
	{
		$object = new AdditionalParentsObject($objectId);
		parent::__construct($object);
	}

	public function get()
    {
        $ids = array(-1);
        foreach ($this as $item)
            $ids[] = $item->id;
        return (new Categories(new GoodConfig()))->setSubquery('AND `id` IN(' . implode(',', $ids) . ')');
    }
}

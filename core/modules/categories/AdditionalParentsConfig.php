<?php
namespace core\modules\categories;
class AdditionalParentsConfig extends \core\modules\base\ModuleConfig
{
	protected $objectClass = '\core\modules\categories\Category';
	protected $objectsClass = '\core\modules\categories\Categories';
	protected $tablePostfix = 'catalog_categories_additionalParents'; // set value without preffix!
	protected $idField = 'objectId';
	protected $objectFields = array(
		'id',
		'ownerId',
		'objectId',
	);

    public function getTablePostfix(){return $this->tablePostfix;}

    public function getTableName()
    {
        return TABLE_PREFIX.$this->tablePostfix;
    }
}

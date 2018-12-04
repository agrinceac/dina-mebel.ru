<?php
namespace core\modules\categories;
class AdditionalParentsObject extends \core\modules\base\ModuleRelations
{
	protected $configClass = '\core\modules\categories\AdditionalParentsConfig';

	function __construct($ownerId)
	{
		parent::__construct($ownerId, new $this->configClass(new CategoryConfig()));
	}
}

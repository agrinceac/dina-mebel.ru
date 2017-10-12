<?php
namespace modules\catalog\goods\lib;
class GoodObject extends \modules\catalog\CatalogGoodObject
{
	protected $configClass = '\modules\catalog\goods\lib\GoodConfig';

	function __construct($objectId)
	{
		parent::__construct($objectId, new $this->configClass);
	}
}
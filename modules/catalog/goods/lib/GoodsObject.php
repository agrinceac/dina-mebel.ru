<?php
namespace modules\catalog\goods\lib;
class GoodsObject extends \modules\catalog\CatalogRegistrator
{
	use \modules\catalog\traits\CatalogWordsSearch;
	protected $configClass = '\modules\catalog\goods\lib\GoodConfig';

	function __construct()
	{
		parent::__construct(new $this->configClass);
	}
}

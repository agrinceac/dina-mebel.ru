<?php
namespace modules\catalog\goods\lib;
class GoodConfig extends \core\modules\base\ModuleConfig
{
	use \core\traits\adapters\Date,
		\core\traits\adapters\Base,
		\core\traits\outAdapters\OutDate,
		\modules\catalog\CatalogValidators,
		\core\traits\validators\Sitemap,
		\core\traits\adapters\Sitemap,
		\core\traits\adapters\Alias,
		\core\traits\validators\Price;

	const ACTIVE_STATUS_ID  = 1;
	const BLOCKED_STATUS_ID = 2;
	const REMOVED_STATUS_ID = 3;
	const HIT_STATUS_ID = 4;

	protected $removedStatus = self::REMOVED_STATUS_ID;

	protected $objectClass  = '\modules\catalog\goods\lib\Good';
	protected $objectsClass = '\modules\catalog\goods\lib\Goods';

	public $templates  = 'modules/catalog/goods/tpl/';
	public $orderGoodAdminTemplate  = 'standartGoods';
	public $imagesPath = 'files/catalog/images/';
	public $imagesUrl  = 'data/images/catalog/';

	protected $table = 'catalog_goods'; // set value without preffix!
	protected $idField = 'id';
	protected $objectFields = array(
		'id',
		'categoryId',
		'statusId',
		'description',
		'text',
		'priority',
		'date',
		'lastUpdateTime',
		'sitemapPriority',
		'changeFreq',
		'alias',
		'name',
		'price',
		'oldPrice',
		'delivery',
		'assembling',
		'stars',
		'slyder',
		'slyderText',
		'instagramImgLink',
		'views'
	);

	public function rules()
	{
		return array(
			'name' => array(
				'validation' => array('_validNotEmpty'),
				'adapt' => '_adaptHtml',
			),
			'alias' => array(
				'adapt' => '_adaptAliasUnique',
			),
			'categoryId, statusId' => array(
				'validation' => array('_validInt', array('notEmpty'=>true)),
			),
			'price' => array(
				'validation' => array('_validPrice', array('notEmpty'=>true)),
			),
			'oldPrice' => array(
				'validation' => array('_validCost'),
			),
//			'delivery, assembling' => array(
//				'validation' => array('_validNotEmpty'),
//				'adapt' => '_adaptHtml',
//			),
			'date' => array(
				'adapt' => '_adaptRegDate',
			),
			'lastUpdateTime' => array(
				'validation' => array('_validLastUpdateTime'),
				'adapt' => '_adaptLastUpdateTime',
			),
			'sitemapPriority' => array(
				'validation' => array('_validSitemapPriority'),
				'adapt' => '_adaptSitemapPriority',
			),
			'changeFreq' => array(
				'validation' => array('_validChangeFreq'),
				'adapt' => '_adaptChangeFreq',
			),
			'stars' => array(
				'validation' => array('_validInt'),
			),
			'slyder' => array(
				'adapt' => '_adaptBool',
			),
		);
	}

	public function outputRules()
	{
		return array(
			'date' => array('_outDate'),
//			'lastUpdateTime' => array('_outDateTime'),
		);
	}
}
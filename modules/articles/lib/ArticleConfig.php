<?php
namespace modules\articles\lib;
class ArticleConfig extends \core\modules\base\ModuleConfig
{
	use \core\traits\validators\Base,
		\core\traits\adapters\Date,
		\core\traits\adapters\Alias,
		\core\traits\adapters\Base,
		\core\traits\outAdapters\OutDate,
		\core\traits\validators\Sitemap,
		\core\traits\adapters\Sitemap;

	const ACTIVE_STATUS_ID = 1;
	const BLOCKED_STATUS_ID = 2;

	const TOP_MENU_CATEGORY_ID = 57;
	const REVIEWS_CATEGORY_ID = 96;

	protected $objectClass  = '\modules\articles\lib\Article';
	protected $objectsClass = '\modules\articles\lib\Articles';

	public $templates  = 'modules/articles/tpl/';
	public $imagesPath = 'files/articles/images/';
	public $imagesUrl  = 'data/images/articles/';

	protected $table = 'articles'; // set value without preffix!
	protected $idField = 'id';
	protected $objectFields = array(
		'id',
		'categoryId',
		'statusId',
		'blank',
		'redirect',
		'priority',
		'name',
		'h1',
		'alias',
		'description',
		'text',
		'date',
		'metaTitle',
		'metaKeywords',
		'metaDescription',
		'lastUpdateTime',
		'sitemapPriority',
		'changeFreq',
	);

	public function rules()
	{
		return array(
			'name' => array(
				'validation' => array('_validNotEmpty'),
			),
			'alias' => array(
				'adapt' => '_adaptAliasUnique',
			),
			'statusId' => array(
				'validation' => array('_validInt', array('notEmpty'=>true)),
			),
			'categoryId' => array(
				'validation' => array('_validInt', array('notEmpty'=>true)),
			),
			'date' => array(
				'adapt' => '_adaptRegDate',
			),
			'metaTitle' => array(
				'adapt' => '_adaptHtml',
			),
			'metaKeywords' => array(
				'adapt' => '_adaptHtml',
			),
			'metaDescription' => array(
				'adapt' => '_adaptHtml',
			),
			'blank' => array(
				'adapt' => '_adaptBool',
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
		);
	}

	public function outputRules()
	{
		return array(
			'date' => array('_outDate'),
			//'lastUpdateTime' => array('_outDateTime'),
		);
	}

}

<?php
namespace core\modules\categories;
use core\modules\base\ModuleConfig;

class CategoryConfig extends ModuleConfig
{
	use \core\traits\adapters\Alias,
        \core\traits\adapters\Base;

    private $catalogTypesArray = array(
	    'category' => array(
	        'alias' => 'category',
            'name' => 'категория',
            'color' => 'blue'
        ),
        'good' => array(
            'alias' => 'good',
            'name' => 'товар',
            'color' => 'green'
        )
    );

	protected $objectClass = '\core\modules\categories\Category';
	protected $objectsClass = '\core\modules\categories\Categories';

	protected $tablePostfix = '_categories'; // set value without preffix!\
	protected $idField = 'id';
	protected $removedStatus = 3;
	protected $objectFields = array(
		'id',
		'statusId',
		'parentId',
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
		'image',
		'bigImage',
		'domainAlias'
	);

    public function __construct($parentConfig = null)
    {
        if($this->isGoodCategory($parentConfig)){
            array_push($this->objectFields, 'credit', 'type');
        }
        parent::__construct($parentConfig);
    }

    private function isGoodCategory($parentConfig)
    {
        return $parentConfig === 'modules\catalog\goods\lib\GoodConfig';
    }

	public function rules()
	{
		return array(
			'name' => array(
				'validation' => array('_validNotEmpty'),
				'adapt' => '_adaptHtml',
			),
			'h1' => array(
				'adapt' => '_adaptHtml',
			),
			'alias' => array(
				'adapt' => '_adaptAliasUnique',
			),
			'statusId' => array(
				'validation' => array('_validInt', array('notEmpty'=>true)),
			),
			'parent_category' => array(
				'validation' => array('_validInt'),
			),
			'date' => array(
				'adapt' => '_adaptRegDate',
			),
			'm_title, m_keywords, m_description, image, bigImage' => array(
				'adapt' => '_adaptHtml',
			),
            'credit' => array(
                'adapt' => '_adaptBool',
            ),
		);
	}

	public function _validNotEmpty($data)
	{
		return !empty($data);
	}

	public function outputRules()
	{
		return array(
			'date' => array('_outDate')
		);
	}

	public function _outDate($data)
	{
		return \core\utils\Dates::convertDate($data, 'simple');
	}

	public function _adaptRegDate($key)
	{
		$this->data[$key] = (!empty($this->data[$key])) ? \core\utils\Dates::convertDate($this->data[$key], 'mysql') : time() ;
	}

	public function getCatalogTypesArray()
    {
        return $this->catalogTypesArray;
    }
}
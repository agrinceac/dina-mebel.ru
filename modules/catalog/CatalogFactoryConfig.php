<?php
namespace modules\catalog;
class CatalogFactoryConfig extends \core\modules\base\ModuleConfig
{
	use \modules\catalog\CatalogValidators;

	protected  $table = 'catalog'; // set value without preffix!

	protected $objectFields = array(
		'id',
		'code',
		'name',
		'class',
	);

	public function rules()
	{
		return array(
// allow the same codes in this project
//			'code' => array(
//				'validation' => array('_validCode'),
//			),
			'name' => array(
				'validation' => array('_validName'),
			),
			'class' => array(
				'validation' => array('_validClass'),
			),
		);
	}
}
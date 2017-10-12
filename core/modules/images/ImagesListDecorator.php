<?php
namespace core\modules\images;
class ImagesListDecorator extends \core\modules\base\ModuleDecorator
{
	public $images;

	function __construct($object)
	{
		parent::__construct($object);
		$this->instantImages($object);
	}

	private function instantImages($object)
	{
		$this->images = new Images($object);
		$this->images->setSubquery(' AND `objectId` = "?d" AND `categoryId`= "?d"', $object->id, 1)
					 ->setOrderBy('`priority` ASC');
	}

	public function getFirstImage()
	{
		return (is_object($image = $this->images->current())) ? $image : $this->getNoop();
	}
}

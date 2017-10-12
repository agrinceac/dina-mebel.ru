<?php
namespace core\modules\images;
class ImagesPrimaryDecorator extends \core\modules\base\ModuleDecorator
{
	public $primaryImages;
	public $primaryImageCategoryId = 2;

	function __construct($object)
	{
		parent::__construct($object);
		$this->instantImages($object);
	}

	private function instantImages($object)
	{
		$this->primaryImages = new Images($object);
		$this->primaryImages->setSubquery(' AND `objectId` = "?d" AND `categoryId`= "?d"', $object->id, $this->primaryImageCategoryId);
	}

	public function getFirstPrimaryImage()
	{
		return (is_object($image = $this->primaryImages->current())) ? $image : $this->getNoop();
	}
}

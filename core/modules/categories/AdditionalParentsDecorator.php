<?php
namespace core\modules\categories;
class AdditionalParentsDecorator extends \core\modules\base\ModuleDecorator
{
	public $additionalParents;
	public $additionalParentsArray = array();
	
	function __construct($object)
	{
		parent::__construct($object);
		$this->instantAdditionalParents()
			->instantAdditionalParentsArray();
	}
	
	function instantAdditionalParents()
	{
		$this->additionalParents = new AdditionalParents($this->id);
		return $this;
	}
	
	function instantAdditionalParentsArray()
	{
		if (!empty($this->additionalParents))
			foreach($this->additionalParents as $category)
				$this->additionalParentsArray[] = $category->id;
		return $this;
	}
}

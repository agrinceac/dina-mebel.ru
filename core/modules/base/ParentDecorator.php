<?php
namespace core\modules\base;
class ParentDecorator extends ModuleDecorator
{
	private $parent;
	private $parentClass;
	private $configObject;
	
	function __construct($object, $configObject = null)
	{
		parent::__construct($object);
		$this->configObject = $configObject;
	}
	
	public function getParent()
	{
		if (empty($this->parent))
			$this->getParentClass($this->getParentObject())->instantParentObject($this->getParentObject()->parentId, $this->configObject);
		return $this->parent;
	}
	
	private function getParentClass($object)
	{
		$this->parentClass = str_replace('Object', '', get_class($object));
		return $this;
	}
	
	private function instantParentObject($parentId, $configObject = null)
	{
		return $this->parent = !empty($parentId) ? $this->getObject($this->parentClass, $parentId, $configObject) : $this->getNoop();
	}

	public function getChildren($statusesArray = array())
	{
		if (!is_array($statusesArray))
			$statusesArray = array((int)$statusesArray);
		$config = clone $this->getConfig();
		$config->removePostfix();
		$className = $config->getObjectsClass();
		$objects = new $className($config);
		if (!empty($statusesArray))
			$objects->setSubquery(' AND `statusId` IN (?s)',  implode(',', $statusesArray));
		$objects->setSubquery(' AND `parentId`= ?d',$this->getParentObject()->id)
				->setOrderBy('`priority` ASC');
		if($objects->count() == 0)
		    return false;
		
		return $objects;
	}

    public function getChildrenTypeCategory($statusesArray = array())
    {
        if (!is_array($statusesArray))
            $statusesArray = array((int)$statusesArray);
        $config = clone $this->getConfig();
        $config->removePostfix();
        $className = $config->getObjectsClass();
        $objects = new $className($config);
        if (!empty($statusesArray))
            $objects->setSubquery(' AND `statusId` IN (?s)',  implode(',', $statusesArray));
        $objects->setSubquery(' AND `parentId`= ?d',$this->getParentObject()->id)
                ->setSubquery(' AND `type` = "category"')
                ->setOrderBy('`priority` ASC');
        if($objects->count() == 0)
            return false;

        return $objects;
    }

    public function getChildrenTypeGood($statusesArray = array())
    {
        if (!is_array($statusesArray))
            $statusesArray = array((int)$statusesArray);
        $config = clone $this->getConfig();
        $config->removePostfix();
        $className = $config->getObjectsClass();
        $objects = new $className($config);
        if (!empty($statusesArray))
            $objects->setSubquery(' AND `statusId` IN (?s)',  implode(',', $statusesArray));

        $objects->setSubquery(
                ' AND ( 
                    ( `parentId` = ?d )
                    OR
                    ( `parentId` IN ( SELECT `id` from `'.$this->getParentObject()->mainTable().'` WHERE `parentId` = ?d) )
                )'
                , $this->getParentObject()->id, $this->getParentObject()->id
            )
            ->setSubquery(' AND `type` = "good"')
            ->setOrderBy('`priority` ASC');

        if($objects->count() == 0)
            return false;

        return $objects;
    }

}
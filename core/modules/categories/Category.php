<?php
namespace core\modules\categories;
class Category extends \core\modules\base\ModuleDecorator implements \interfaces\IObjectToFrontend
{
	function __construct($objectId, $configObject)
	{
		$object = new CategoryObject($objectId, $configObject);
        $object = new \core\modules\base\ParentDecorator($object, $configObject);
        $object = new \core\modules\categories\AdditionalParentsDecorator($object);
		$object = new \core\modules\statuses\StatusDecorator($object);
		parent::__construct($object);
	}

    public function edit ($data, $fields = array())
    {
        if ( $this->additionalParents->edit($data->additionalParents) )
            return $this->getParentObject()->edit($data, $fields);
        return false;
    }

	public function getH1()
	{
		return empty($this->h1) ? $this->name : $this->h1;
	}

	/* Start: Meta Methods */
	public function getMetaTitle()
	{
	    return $this->getH1();
//		return $this->metaTitle;
	}

	public function getMetaDescription()
	{
		return $this->metaDescription;
	}

	public function getMetaKeywords()
	{
		return $this->metaKeywords;
	}
	/*   End: Meta Methods */

	/* Start: Main Data Methods */
	public function getName()
	{
		return $this->name;
	}
	/*   End: Main Data Methods */

	/* Start: URL Methods */
	public function getPath()
	{
        $object = $this->getParentObject();

        if($object->type === 'good'){
            $object = $object->getParent()->getParent();
            return $object->getPath().$this->alias.'/';
        }

        return $object->getPath();

//		$categoryRules = new CategoriesAliasesRules;
//		return $categoryRules->useRules($this->getParentObject()->getPath());
	}
	/*   End: URL Methods */

	/* Start: Sitemap Methods */
	public function getLastUpdateTime()
	{
		return time();
	}

	public function getSitemapPriority()
	{
		return '0.7';
	}

	public function getChangeFreq()
	{
		return 'daily';
	}
	/*   End: Sitemap Methods */

	public function getTypeAlias()
    {
        return $this->type;
    }

    public function getTypeName()
    {
        return (new CategoryConfig())->getCatalogTypesArray()[$this->type]['name'];
    }

    public function getTypeColor()
    {
        return (new CategoryConfig())->getCatalogTypesArray()[$this->type]['color'];
    }
}

<?php
namespace modules\catalog\goods\lib;
class Good extends \modules\catalog\CatalogGood implements \interfaces\IObjectToFrontend, \interfaces\IGoodForShopcart
{
	use \core\traits\RequestHandler;

	function __construct($objectId)
	{
		$object = new GoodObject($objectId);
		$object = new \core\modules\categories\CategoryDecorator($object);
        $object = new \core\modules\categories\AdditionalCategoriesDecorator($object);
		$object = new \core\modules\statuses\StatusDecorator($object);
		$object = new \core\modules\images\ImagesDecorator($object);
		$object = new \core\modules\images\ImagesListDecorator($object);
		parent::__construct($object);
	}

    public function edit ($data, $fields = array())
    {
        if ( $this->additionalCategories->edit($data->additionalCategories) )
            return $this->getParentObject()->edit($data, $fields);
        return false;
    }

	public function getOldPrice()
	{
		return $this->oldPrice ? $this->oldPrice : false;
	}

	public function getDiscount()
	{
		return $this->oldPrice ? $this->oldPrice - $this->price : false;
	}

	/* Start: Meta Methods */
	public function getMetaTitle()
	{
		return $this->metaTitle ? $this->metaTitle : $this->getName();
	}

	public function getMetaDescription()
	{
		return $this->metaDescription ? $this->metaDescription : $this->getName();;
	}

	public function getMetaKeywords()
	{
		return $this->metaKeywords ? $this->metaKeywords : $this->getName();;
	}
	/*   End: Meta Methods */

	/* Start: URL Methods */
	public function getPath()
	{
		return $this->getCategory()->getPath().$this->alias.'/';
	}
	/*   End: URL Methods */

	public function getPathByDomainAlias($domainAlias)
	{
		if ($this->getCategory()->getParent()->alias == 'igrovie_konstrukcii')
			return '/'.$this->getCategory()->alias.'/'.$this->getDomainInfoByDomainAlias($domainAlias)->alias.'/';
		return $this->getCategory()->getPath().$this->getDomainInfoByDomainAlias($domainAlias)->alias.'/';
	}

	public function isValidPath($path)
	{
		return $this->getPath() == rtrim($path,'/').'/';
	}

	/* Start: IGoodForShopcart Methods */
	public function getMinQuantity()
	{
		return 1;
	}

	public function getPriceByQuantity($quantity)
	{
		return $this->price;
	}

	public function getPriceByMinQuantity()
	{
		return $this->getPriceByQuantity($this->getMinQuantity());
	}

	public function getPathToShopcartGoodTemplate()
	{
		 return $this->getConfig()->shopcartTemplate;
	}
	/* End: IGoodForShopcart Methods */

	/* Start: IGoodForOrder Methods */
	public function getBasePriceByQuantity($quantity)
	{
		return $this->getPrices()->getPriceByQuantity($quantity)->getBasePrices()->getMinBasePrice()->price;
	}

	public function getBasePriceByMinQuantity()
	{
		return $this->getPrices()->getPriceByQuantity($this->getMinQuantity())->getBasePrices()->getMinBasePrice()->price;
	}

	public function getPathToOrderGoodTemplate()
	{
		 return $this->getConfig()->orderTemplate;
	}

	public function getPathToAdminOrderGoodTemplate()
	{
		return $this->getConfig()->orderGoodAdminTemplate;
	}
	/* End: IGoodForOrder Methods */

	public function getInfo()
	{
		return $this->getDomainInfoByDomainAlias($this->getCurrentDomainAlias());
	}

	public function getAvailabilityList()
	{
		return $this->getParentObject()->getAvailabilityList();
	}

	/* Start: Sitemap Methods */
	public function getLastUpdateTime()
	{
		return $this->lastUpdateTime;
	}

	public function getSitemapPriority()
	{
		return empty($this->sitemapPriority) ? '0.5' : $this->sitemapPriority;
	}

	public function getChangeFreq()
	{
		return empty($this->changeFreq) ? 'weekly' : $this->changeFreq;
	}
	/*   End: Sitemap Methods */

	public function remove () {
		return ($this->delete()) ? (int)$this->id : false ;
	}
	
	public function edit_single ($data, $fields = array())
	{
		return $this->getParentObject()->editField($data, $fields);
	}
	
	public function getViewsCount()
	{
		return $this->views;
	}
	
	public function IncrementViewsCount()
	{
		$CurrentViews = $this->views;
		$IncViews = $CurrentViews + 1;
		$this->edit_single($IncViews, 'views');
	}
	
	public function GetStarsByViews()
	{
		$CurrentViews = $this->views;
		$max = \modules\catalog\CatalogFactory::getInstance()->getMaxProductViews();
		$factor = $max/5;
		$stars = 0;
		
		switch ($factor) {
			case ($CurrentViews < $factor) || ($CurrentViews < $factor+1):
				$stars = 1;
				break;
			case $CurrentViews < $factor*2:
				$stars = 2;
				break;
			case $CurrentViews < $factor*3:
				$stars = 3;
				break;
			case $CurrentViews < $factor*4:
				$stars = 4;
				break;
			case ($CurrentViews < $factor*5) || ($CurrentViews = $factor*5):
				$stars = 5;
				break;
		}
		return $stars;
	}
	
	public function SetStars()
	{
		$this->stars = $this->GetStarsByViews();
	}

}
<?php
namespace modules\articles\lib;
class Article extends \core\modules\base\ModuleDecorator implements \interfaces\IObjectToFrontend
{
	function __construct($objectId)
	{
		$object = new ArticleObject($objectId);
		$object = new \core\modules\categories\CategoryDecorator($object);
		$object = new \core\modules\statuses\StatusDecorator($object);
		$object = new \core\modules\images\ImagesDecorator($object);

		parent::__construct($object);
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

	/* Start: Main Data Methods */
	public function getName()
	{
		return $this->name;
	}
	/*   End: Main Data Methods */

	public function getH1()
	{
		return empty($this->h1) ? $this->name : $this->h1;
	}

	/* Start: URL Methods */
	public function getPath()
	{
		if ($this->alias == 'index')
			return '/';

		$config = $this->getConfig();
		if ($this->getCategory()->id == $config::REVIEWS_CATEGORY_ID)
			return false;
		
		return '/'.$this->alias.'/';
	}
	/*   End: URL Methods */

	public function isValidPath($path)
	{
		return $this->getPath() == rtrim($path,'/').'/';
	}

	public function remove () {
		return ($this->delete()) ? (int)$this->id : false ;
	}

	/* Start: Sitemap Methods */
	public function getLastUpdateTime()
	{
		return empty($this->lastUpdateTime) ? time() : $this->lastUpdateTime;
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
}
<?php
namespace controllers\front\service;
class DiaMebelServiceFrontController extends \controllers\base\Controller
{
	use	\core\traits\controllers\ControllersHandler,
		\core\traits\controllers\Templates;

	private $actionsRedirects = array(
		'sitemap.xml'	=> 'sitemap',
		'robots.txt'	=> 'robots',
		'YML.xml'		=>'yml'
	);

	public function __call($actionName, $arguments)
	{
		if (method_exists($this, $actionName))
			return call_user_func_array(array($this, $actionName), $arguments);
		elseif (isset($this->actionsRedirects[$actionName])){
			$action = $this->actionsRedirects[$actionName];
			return $this->$action();
		} else {
			$defaultControllerName = \core\Configurator::getInstance()->controllers->defaultFrontController;
			return $this->getController($defaultControllerName)->$actionName();
		}
	}

	public function redirect404()
	{
		header("HTTP/1.0 404 Not Found");
		$this->includeTemplate('404');
	}

	public function accessDenied($right)
	{
		$this->redirect404();
	}

	public function forbidden()
	{
		$this->redirect404();
	}

	protected function sitemap()
	{
		if ($this->getSERVER()['REQUEST_URI'] != '/sitemap.xml')
			return $this->redirect404();

		(new \core\seo\sitemap\Sitemap())
			->addObjects($this->getGoodCategories())
//			->addObjects($this->getGoods())
			->addObjects($this->getArticles())
			->printSitemap();
	}

	protected function getGoodCategories()
	{
		return (new \modules\catalog\goods\lib\Goods())->getCategories()->setSubquery(' AND `statusId` = ?d', 1);
	}

	protected function getGoods()
	{
		return (new \modules\catalog\goods\lib\Goods())->setSubquery(
			' AND `statusId` NOT IN (?d, ?d)',
				\modules\catalog\goods\lib\GoodConfig::BLOCKED_STATUS_ID,
				\modules\catalog\goods\lib\GoodConfig::REMOVED_STATUS_ID
		);
	}

	protected function getArticles()
	{
//		$articles = new \modules\articles\lib\Articles();
//		$query = '
//			AND `statusId` = ?d
//			AND `categoryId` IN (?s)
//			AND `categoryId` IN (
//				SELECT
//					`id`
//				FROM
//					`'.$articles->getCategories()->mainTable().'`
//				WHERE
//					`domainAlias` = "?s"
//			)';
//		return $articles->setSubquery($query, \modules\articles\lib\ArticleConfig::ACTIVE_STATUS_ID, '57,82,59,83', $this->getCurrentDomainAlias());

		return (new \modules\articles\lib\Articles())->setSubquery(
			' AND `statusId` = ?d', \modules\articles\lib\ArticleConfig::ACTIVE_STATUS_ID
		);
	}

	protected function robots()
	{
		if ($this->getSERVER()['REQUEST_URI'] != '/robots.txt')
			return $this->redirect404();
		$filePath = DIR.'/robots/'.$this->getDevelopersDomainAlias().'Robots.txt';
		if (file_exists($filePath)){
			header('Content-type: text/plain');
			include($filePath);
		}else
			$this->redirect404();
	}

	protected function yml()
	{
		if ($this->getSERVER()['REQUEST_URI'] != '/YML.xml')
			return $this->redirect404();
		$yml = new \core\seo\yml\Yml();
		$yml->addCategories($this->getController('Catalog')->getMainCategories());

		foreach($this->getController('Catalog')->getMainCategories() as $mainCategories){
		    $children = $mainCategories->getChildren();
		    if($children){
                foreach($children as $complect){
                    if ($this->categoryNotEmpty($complect)) {
                        $yml->addOffer($this->getYmlOfferFromComplect($complect));
                        foreach ($this->getController('Catalog')->getGoodsByCategory($complect) as $good)
                            $yml->addOffer($this->getYmlOfferFromGood($good));
                    }
                }
            }
        }

		$yml->printYml();
	}

	protected function getYmlOfferFromComplect($complect)
	{
		$pictures = array();
		foreach($this->getController('Catalog')->getMainGood($complect->id)->getImagesByCategoryAndStatus(1, 1) as $image)
			$pictures[] = $image->getImage();
		foreach($this->getController('Catalog')->getMainGood($complect->id)->getImagesByCategoryAndStatus(2, 1) as $image)
			$pictures[] = $image->getImage();

		$data = array(
			'id'		=> $complect->id,
			'available' => $complect->statusId==$this->getController('Catalog')->getActiveCategoryStatus() ? 'true' : 'false',
			'url'		=> $complect->getPath(),
			'price'		=> $this->getController('Catalog')->getMainGood($complect->id)->getPriceByQuantity(1),
			'currencyId'=> 'RUR',
			'categoryId'=> $complect->parentId,
			'pictures' => $pictures,
			'name'		=> $complect->getName(),
			'description'=> strip_tags($complect->description),
			'manufacturerWarranty' => true,
			'delivery' => true,
			'deliveryCost' => (int)preg_replace('~\D+~', '', $this->getController('Catalog')->getMainGood($complect->id)->delivery)
		);
		return new \core\seo\yml\YmlOffer($data);
	}

	protected function getYmlOfferFromGood($good)
	{
		$pictures = array();
		foreach($good->getImagesByCategoryAndStatus(1, 1) as $image)
			$pictures[] = $image->getImage();
		foreach($good->getImagesByCategoryAndStatus(2, 1) as $image)
			$pictures[] = $image->getImage();

		$data = array(
			'id'		=> $good->id,
			'available' => in_array($good->statusId, $this->getController('Catalog')->getExludedStatusesArray()) ? 'false' : 'true',
			'url'		=> $good->getPath(),
			'price'		=> $good->getPriceByQuantity(1),
			'currencyId'=> 'RUR',
			'categoryId'=> isset($good->getCategory()->parentId) ? $good->getCategory()->parentId : $good->getCategoryId,
			'pictures' => $pictures,
			'name'		=> $good->getName(),
			'description'=> strip_tags($good->description),
			'manufacturerWarranty' => true,
			'delivery' => true,
			'deliveryCost' => (int)preg_replace('~\D+~', '', $this->getController('Catalog')->getMainGood($good->categoryId)->delivery)
		);
		return new \core\seo\yml\YmlOffer($data);
	}

	protected function categoryNotEmpty($category)
    {
        return $this->getController('Catalog')->getGoodsByCategory($category)->count() > 0;
    }
}
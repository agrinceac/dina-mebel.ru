<?php
namespace controllers\front\catalog;
use core\modules\categories\AdditionalCategoriesConfig;

class DiaMebelCatalogFrontController extends \controllers\base\Controller
{
	use	\core\traits\controllers\Meta,
		\core\traits\controllers\Templates,
		\core\traits\composition\RequestLevels_RequestHandler,
		\core\traits\Pager,
		\core\traits\controllers\Authorization,
		\core\traits\controllers\Breadcrumbs;

	const ACTIVE_CATEGORY_STATUS = 1;
	const SIMILAR_CATEGORIES_QUANTITY = 2;
	const HIT_GOODS_QUANTITY = 6;

	protected $permissibleActions = array(
		'getLeftCategoriesBlock',
		'getMainGood',
		'getSimilarNotMainCategories',
		'getCatalogObjectTemplateBlock',
		'getHitGoodsBlock',
		'getSlyderBlock',
		'getCategoryByAlias',
		'search',
		'getActiveCategoryStatus',
		'getGoodsByCategory',
		'getExludedStatusesArray'
	);

	protected $goods;

	public function __call($name, $arguments)
	{
		if (empty($name))
			return $this->defaultAction();
		elseif ($this->setAction($name)->isPermissibleAction())
			return $this->callAction($arguments);
		else
			return $this->pageDetect();
	}

	protected function defaultAction()
	{
		$this->getController('Article')->viewIndex();
	}

	protected function pageDetect()
	{
		$alias = $this->getLastElementFromRequest();
		$category = $this->getCategoryByAlias($alias);
		if ($category){
			if ($this->checkObjectPath($category)){
				if($category->getChildren(array(1)))
					return $this->viewCategory($category);
				else
					return $this->viewFinalCategory($category);
			}

		}
		$this->getController('Article')->defaultAction();
	}

	protected function getCategoryByAlias($alias)
	{
		return $this->getGoodsObject()->getCategories()->getObjectByAlias($alias);
	}

	protected function viewCategory($category)
	{
		$this->setTotalLevels($category);
		$objects = $category->getChildren(array(self::ACTIVE_CATEGORY_STATUS));

		if ($category->alias == 'spalni') {
			$quantityItemsOnSubpageList = 50;
		} else {
			$quantityItemsOnSubpageList = 14;
		}

		if ( $objects->count() > 0 ) {
			$objectsCount = $objects->count();
			$objects->setSubquery('AND `statusId` NOT IN (?s)', implode(',', $this->getExludedStatusesArray()))
                    ->setSubquery('AND `id` IN (SELECT DISTINCT `categoryId` FROM `tbl_catalog_goods` 
                        WHERE statusId NOT IN (?s))', implode(',', $this->getExludedStatusesArray())
                    )
					->setQuantityItemsOnSubpageList(array($quantityItemsOnSubpageList))
					->setPager($quantityItemsOnSubpageList);
		}
		if($objects->getPager()->current()->getCurrentPage() > $objects->getPager()->getTotalPages())
			return $this->redirect404();

		$this->setMetaFromObject($category)
			->setContent('category', $category)
			->setContent('objects', $objects)
			->setContent('objectsCount', $objectsCount)
			->setContent('quantityItemsOnSubpageList', $quantityItemsOnSubpageList)
			->includeTemplate('catalog/catalogList');
	}

	protected function viewFinalCategory($category)
	{
		$this->setTotalLevels($category);
		$this->setResentViewedCategories($category);
//		unset($_SESSION['recentViewedCategories']);

		$this->setMetaFromObject($category)
			->setContent('mainGood', $this->getMainGood($category->id))
			->setContent('objects', $this->getGoodsByCategory($category))
			->setContent('category', $category)
			->setContent('similarNotMainCategories', $this->getSimilarNotMainCategories($category))
			->includeTemplate('catalog/catalogObject');
	}

	protected function getGoodsByCategory($category)
	{
		return $this->getGoodsObject()
					->resetFilters()
					->setSubquery('AND (')
                        ->setSubquery('`categoryId` = ?d', $category->id)
                        ->setSubquery('OR `id` IN (
                                SELECT `ownerId` FROM
                                `'.$this->getGoodsObject()->getConfig()->mainTable().(new AdditionalCategoriesConfig())->getTablePostfix().'`
                                 WHERE `objectId` = ?d
                            )', $category->id)
                    ->setSubquery(') ')
					->setSubquery('AND `statusId` NOT IN (?s)', implode(',', $this->getExludedStatusesArray()))
					->setOrderBy('`priority` ASC, `id` ASC');
	}

	private function setResentViewedCategories($category)
	{
		if(!isset($_SESSION['recentViewedCategories']))
			$_SESSION['recentViewedCategories'] = array();
		if(!in_array($category->id, $_SESSION['recentViewedCategories']))
			$_SESSION['recentViewedCategories'][$category->id] = $category->alias;
		if(count($_SESSION['recentViewedCategories']) > 4)
			foreach($_SESSION['recentViewedCategories'] as $key=>$value){
				unset($_SESSION['recentViewedCategories'][$key]);
				return true;
			}

	}

	private function getSimilarNotMainCategories($category)
	{
		$categories = new \core\modules\categories\Categories($this->getObject('\modules\catalog\goods\lib\GoodConfig'));
		$categories->resetFilters();
		$categories->setSubquery('AND `parentId` = ?d', $category->getParent()->id)
                ->setSubquery('AND `parentId` != ?d', 0)
				->setSubquery('AND `id` != ?d', $category->id)
				->setSubquery('AND `statusId` = ?d', self::ACTIVE_CATEGORY_STATUS)
				->setOrderBy('RAND()')
				->setLimit(self::SIMILAR_CATEGORIES_QUANTITY);

		return $categories;
	}

	protected function getGoodsObject()
	{
		return new \modules\catalog\goods\lib\Goods();
	}

	protected function getExludedStatusesArray()
	{
		return $exludedStatuses = array(
			\modules\catalog\goods\lib\GoodConfig::BLOCKED_STATUS_ID,
			\modules\catalog\goods\lib\GoodConfig::REMOVED_STATUS_ID,
		);
	}

	protected function getGoodByAlias($alias)
	{
		$goods = $this->getObject('\modules\catalog\goods\lib\Goods');
		$goodId = $goods->getIdByAlias($alias) ? $goods->getIdByAlias($alias) : false;
		return $goodId ? $this->getObject('\modules\catalog\goods\lib\Good', $goods->getIdByAlias($alias)) : false;
	}

	protected function checkObjectPath($object)
	{
		return rtrim($object->getPath(), '/') == rtrim(str_replace('?'.$this->getSERVER()['REDIRECT_QUERY_STRING'], '', $this->getSERVER()['REQUEST_URI']), '/');
	}

	protected function getLeftCategoriesBlock()
	{
	    $this->setContent('categories', $this->getMainCategories())
			->setContent('activeCategoryStatus', self::ACTIVE_CATEGORY_STATUS)
			->includeTemplate('catalog/leftCategoriesMenu');
	}

	public function getMainCategories()
	{
		return $this->getGoodsObject()->getMainCategories(self::ACTIVE_CATEGORY_STATUS);
	}

	protected function getMainGood($categoryId)
	{
		$objects = $this->getGoodsObject();
		$objects->resetFilters();
		$objects->setSubquery('AND `categoryId` =  ?d ', $categoryId)
				->setOrderBy('`priority` ASC, `id` ASC')
				->setLimit(1);
		return $objects->current();
	}

	protected function getCatalogObjectTemplateBlock($object, $iteration, $imgSize = null)
	{
		if($imgSize)
			$this->setContent ('imgSize', $imgSize);
		$this->setContent('object', $object)
			->setContent('iteration', $iteration)
			->setContent('good', $this->getMainGood($object->id))
			->includeTemplate('catalog/catalogObjectTemplate');
	}

	protected function getHitGoodsBlock()
	{
		$objects = $this->getGoodsObject();
		$objects->resetFilters();
		$objects->setSubquery('AND `statusId` = ?d', \modules\catalog\goods\lib\GoodConfig::HIT_STATUS_ID)
				->setLimit(self::HIT_GOODS_QUANTITY)
				->setOrderBy('`priority` ASC, `id` ASC');
		$this->setContent('objects', $objects)
			->includeTemplate('catalog/hitGoodsBlock');
	}

	protected function getSlyderBlock()
	{
		$objects = $this->getGoodsObject();
		$objects->resetFilters();
		$objects->setSubquery('AND `statusId` NOT IN (?s)', implode(',', $this->getExludedStatusesArray()))
				->setSubquery('AND `slyder` = ?d', 1)
				->setOrderBy('`priority` ASC, `id` ASC');
		$this->setContent('objects', $objects)
			->includeTemplate('catalog/slyderBlock');
	}

	protected function search()
	{
		$searchText = trim($this->getGET()['query']);
		if( empty ( $searchText ) )
			return $this->redirect404 ();

		$this->setLevel('Поиск');
		$objects = $this->getGoodsObject()->getCategories();
		if ( $objects->count() > 0 ) {
			$objects->resetFilters();
			$objects->setSubquery('AND (`description` LIKE \'%?s%\'  OR  `name` LIKE \'%?s%\' )', trim($this->getGET()['query']), trim($this->getGET()['query']))
					->setSubquery('AND `parentId` != ?d', 0)
					->setSubquery('AND `statusId` NOT IN (?s)', implode(',', $this->getExludedStatusesArray()));
		}

		$this->setContent('title', 'Найденные объекты по запросу "'.$this->getGET()['query'].'"')
			->setContent('objects', $objects)
			->includeTemplate('catalog/catalogList');
	}

	protected function getActiveCategoryStatus()
	{
		return self::ACTIVE_CATEGORY_STATUS;
	}
}
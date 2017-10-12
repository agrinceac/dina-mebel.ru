<?php
namespace controllers\front\article;
use core\utils\Utils;

class DiaMebelArticleFrontController extends \controllers\base\Controller
{
	use	\core\traits\Pager,
		\core\traits\controllers\Meta,
		\core\traits\controllers\Templates,
		\core\traits\controllers\ControllersHandler,
		\core\traits\controllers\RequestLevels,
		\core\traits\controllers\Breadcrumbs;

	private $articleObject;

	public function __construct()
	{
		parent::__construct();
	}

	public function __call($name, $arguments)
	{
		$this->defaultAction();
	}

	public function defaultAction()
	{
		if (!$this->action && $this->getSERVER()['REQUEST_URI']=='/')
			$this->action = 'viewIndex';
		if(isset ($this->getREQUEST()[0]))
			$this->action = $this->getREQUEST()[0];
		if ($this->actionExists($this->action)) {
			$action = $this->action;
			$this->$action();
		} else
			$this->viewArticle($this->action);
	}

	public function viewArticle($alias)
	{
		if ($this->checkArticleAlias($alias)) {
			$articles = new \modules\articles\lib\Articles();
			$article = $articles->getObjectByAlias($alias);
			if ($article->isValidPath( Utils::removeGetString( $this->getSERVER()['REQUEST_URI'] )))
				return $this->setContent('article', $article)
							->setMetaFromObject($article)
							->setLevel($article->name)
							->includeTemplate('articles/article');
		}
		$this->redirect404();
	}

	private function checkArticleAlias($alias)
	{
		return $this->getArticleObject()->checkAlias($alias);
	}

	public function viewIndex()
	{
		$article = $this->getArticle('index');
		$this->setContent('article', $article)
			->setMetaFromObject($article)
			->includeTemplate('index');
	}

	public function getArticle ($alias) {
		$articles = new \modules\articles\lib\Articles();
		return new \modules\articles\lib\Article($articles->getIdByAlias($alias));
	}

	private function getArticleObject()
	{
		if (!isset($this->articleObject))
			$this->setArticlesObject();
		return $this->articleObject;
	}

	private function setArticlesObject()
	{
		$this->articleObject = new \modules\articles\lib\Articles();
	}

	public function getTopMenu()
	{
		$this->setContent('topMenu', $this->getTopMenuItems())
			 ->includeTemplate('articles/topMenu');
	}

	public function getTopMenuItems()
	{
		return $this->setMenuData(\modules\articles\lib\ArticleConfig::TOP_MENU_CATEGORY_ID, \modules\articles\lib\ArticleConfig::ACTIVE_STATUS_ID);
	}

	private function setMenuData($category, $status)
	{
		$filters = new \core\FilterGenerator();
		$filters->setSubquery('AND mt.`categoryId` = ?d AND mt.`statusId` = ?d',$category,$status);
		$filters->setOrderBy('`priority` ASC');
		$articles = new \modules\articles\lib\Articles();
		$articles->setFilters($filters);
		return $articles;
	}

	public function reviews()
	{
		$article = $this->getArticle('reviews');
		$articles = $this->setMenuData(\modules\articles\lib\ArticleConfig::REVIEWS_CATEGORY_ID, \modules\articles\lib\ArticleConfig::ACTIVE_STATUS_ID);
		$articles->setOrderBy('`date` DESC');
		$this->setContent('articles', $articles)
			->setContent('article', $article)
			->setMetaFromObject($article)
			->setLevel($article->name)
			->includeTemplate('articles/reviews');
	}
}

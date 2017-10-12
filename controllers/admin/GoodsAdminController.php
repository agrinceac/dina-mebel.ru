<?php
namespace controllers\admin;
use core\modules\categories\AdditionalCategoriesConfig;

class GoodsAdminController extends \controllers\base\Controller
{
	use	\core\traits\controllers\Rights,
		\core\traits\controllers\Templates,
		\core\traits\controllers\Authorization,
		\core\traits\Pager,
		\core\traits\controllers\Categories,
		\core\traits\controllers\Images;

	protected $permissibleActions = array(
		'goods',
		'good',
		'add',
		'edit',
		'remove',
		'ajaxGetMainContentBlock',
		'changePriority',
		'groupActions',
		'groupRemove',
		'getLastGoods',
		'editGood',

		// Start: Categories Trait Methods
		'categories',
		'categoryAdd',
		'categoryEdit',
		'category',
		'removeCategory',
		'getMainCategories',
		'changeCategoriesPriority',
		//   End: Categories Trait Methods

		// Start: Images Trait Methods
		'uploadImage',
		'addImagesFromEditPage',
		'removeImage',
		'setPrimary',
		'resetPrimary',
		'setBlock',
		'resetBlock',
		'editImage',
		'getTemplateToEditImage',
		'ajaxGetImagesBlock',
		'ajaxGetImagesListBlock',
		'createTable',
		// End: Images Trait Methods

		'updateDescriptions',
	);

	protected $permissibleActionsForManagersUsers = array(
		'goods',
		'good',
		'getLastGoods',
	);

	public function  __construct()
	{
		parent::__construct();
		$this->_config = new \modules\catalog\goods\lib\GoodConfig();
		$this->objectClass = $this->_config->getObjectClass();
		$this->objectsClass = $this->_config->getObjectsClass();
		$this->objectClassName = $this->_config->getObjectClassName();
		$this->objectsClassName = $this->_config->getObjectsClassName();

		if($this->isAuthorisatedUserAnManager())
			$this->permissibleActions = $this->permissibleActionsForManagersUsers;
	}

	protected function defaultAction()
	{
		return $this->goods();
	}

	protected function goods()
	{
		$this->checkUserRightAndBlock('goods');
		$this->rememberPastPageList($_REQUEST['controller']);

		$this->setObject($this->objectsClass);

		$start_date = (empty($this->getGET()['start_date'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['start_date']);
		$end_date = (empty($this->getGET()['end_date'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['end_date']);
		$status = (empty($this->getGET()['statusId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['statusId']);
		$category = (empty($this->getGET()['categoryId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['categoryId']);
		$id = (empty($this->getGET()['id'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['id']);
		$name = (empty($this->getGET()['name'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['name']);
		$code = (empty($this->getGET()['code'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['code']);
		$description = (empty($this->getGET()['description'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['description']);
		$text = (empty($this->getGET()['text'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['text']);
        $slyder = (empty($this->getGET()['slyder'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['slyder']);
		$itemsOnPage = (empty($this->getGET()['itemsOnPage'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['itemsOnPage']);


		if (!empty($this->getGET()['id']))
			$this->modelObject->setSubquery('AND `id` = ?d', $this->getGET()['id']);

		if (!empty($start_date))
			$this->modelObject->setSubquery('AND `date` >= ?d', \core\utils\Dates::convertDate($start_date));

		if (!empty($end_date))
			$this->modelObject->setSubquery('AND `date` <= ?d', \core\utils\Dates::convertDate($end_date));

		if (!empty($category))
            $this->modelObject->setSubquery('AND `categoryId` = ?d', $category)
                            ->setSubquery('OR `id` IN (
                                            SELECT `ownerId` FROM 
                                            `'.$this->_config->mainTable().(new AdditionalCategoriesConfig())->getTablePostfix().'`
                                             WHERE `objectId` = ?d
                                        )', $category);

		if (!empty($status))
			$this->modelObject->loadWithRemovedObjects()->setSubquery('AND `statusId` = ?d', $status);

		if (!empty($id))
			$this->modelObject->setSubquery('AND `id` = ?d', $id);

		if (!empty($description))
			$this->modelObject->setSubquery('AND `description` LIKE \'%?s%\'', $description);

		if (!empty($name))
			$this->modelObject->setSubquery('AND `id` IN (SELECT `id`  FROM `'.\modules\catalog\CatalogFactory::getInstance()->mainTable().'` WHERE LOWER(`name`) LIKE \'%?s%\')', strtolower($name));

		if (!empty($code))
			$this->modelObject->setSubquery('AND `id` IN (SELECT `id`  FROM `'.\modules\catalog\CatalogFactory::getInstance()->mainTable().'` WHERE LOWER(`code`) LIKE \'%?s%\')', strtolower($code));

		if (!empty($text))
			$this->modelObject->setSubquery('AND `text` LIKE \'%?s%\'', $text);

        if (!empty($slyder))
            $this->modelObject->setSubquery('AND `slyder` = ?d', $slyder);

		$this->modelObject->setOrderBy('`priority` ASC')->setPager($itemsOnPage);

		$this->setContent('objects', $this->modelObject)
			 ->setContent('pager', $this->modelObject->getPager())
			 ->setContent('pagesList', $this->modelObject->getQuantityItemsOnSubpageListArray())
			 ->includeTemplate($this->_config->getAdminTemplateDir().'goods');
	}

	protected function add()
	{
		$this->checkUserRightAndBlock('good_add');
		$this->setObject($this->_config->getObjectsClass());
		$objectId = $this->modelObject->setCode($this->getPOST()['code'])
									  ->setName($this->getPOST()['name'])
									  ->add($this->getPOST(), $this->modelObject->getConfig()->getObjectFields());
		$this->ajax($objectId);
	}

	protected function edit()
	{
		$this->checkUserRightAndBlock('good_edit');
		$post = $this->getPost();
		$post['slyder'] = isset($post['slyder']) ? $post['slyder'] : 0;
		$this->setObject($this->_config->getObjectClass(), (int)$post['id'])
			 ->ajax($this->modelObject->edit($post));
	}

	protected function good()
	{
		$this->checkUserRightAndBlock('good');
		$this->useRememberPastPageList();

		$object = isset($this->getREQUEST()[0])
			? $this->getObject($this->_config->getObjectClass(), $this->getREQUEST()[0])
			: new \core\Noop();

		$this->setContent('object', $object)
			 ->includeTemplate($this->_config->getAdminTemplateDir().'good');
	}

	protected function ajaxGetMainContentBlock()
	{
		return $this->getMainContentBlock($this->getPOST()['objectId']);
	}

	protected function getMainContentBlock($catalogId)
	{
		$object = isset($catalogId)
			? \modules\catalog\CatalogFactory::getInstance()->getGoodById($catalogId)
			: new \core\Noop();

		$objects = new $this->objectsClass;

		$tabs = array('editGood' => 'Общая информация');

		$this->setContent('object', $object)
			 ->setContent('objects', $objects)
			 ->setContent('tabs', $tabs)
			 ->includeTemplate($this->_config->getAdminTemplateDir().'main');
	}

	protected function remove()
	{
		$this->checkUserRightAndBlock('good_delete');
		if (isset($this->getREQUEST()[0]))
			$goodId = (int)$this->getREQUEST()[0];

		if (!empty($goodId)) {
			$good = $this->getObject($this->_config->getObjectClass(), $goodId);
			$this->ajaxResponse($good->remove());
		}
	}

	protected function groupActions ()
	{
		if (empty($_POST['categoryId']) && empty($_POST['statusId'])) {
			echo $this->ajaxResponse(array('categoryId'=>'Выберите изменяемое свойство!'));
		} else
			if (empty($_POST['group']))
				echo $this->ajaxResponse(array('code'=>'2', 'message'=>'Выберите объекты для изменения'));
			else {
				foreach ($_POST['group'] as $key=>$objectId) {
					$data = array();
					$data = array_merge($_POST, $data);
					unset($data['group']);
					if (empty($data['categoryId']))
						unset($data['categoryId']);
					if (empty($data['statusId']))
						unset($data['statusId']);

					$object = $this->getObject($this->objectClass, $objectId);
					$data['name'] = $object->getName();
					$data['code'] = $object->getCode();
					$data['additionalCategories'] = $object->additionalCategoriesArray;
					$data = new \core\ArrayWrapper($data);
					$this->setObject($object)->ajax($this->modelObject->edit($data), 'ajax', true);
				}
			}
	}

	protected function getLastGoods($quantity)
	{
		$this->setObject( '\modules\catalog\goods\lib\Goods' );
		$objects = $this->modelObject->setOrderBy('`date` DESC, `id` DESC')->setLimit($quantity);
		return $this->checkUserRight('goods') ? $objects : false;
	}

	protected function editGood()
	{
		$this->checkUserRightAndBlock('good_edit');
		$good = $this->getObject($this->objectClass, $this->getGET()->goodId);
		$edit = $good->edit($this->getPOST());
		$this->ajaxResponse($edit);
	}
}

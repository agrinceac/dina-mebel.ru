<?php
namespace controllers\admin;
class OrdersAdminController extends \controllers\base\Controller
{
	use	\core\traits\controllers\Rights,
		\core\traits\controllers\Templates,
		\core\traits\controllers\Authorization,
		\core\traits\Pager,
		\core\traits\controllers\Categories,
		\core\traits\controllers\Files;

	const MANAGER_USER_CLASS  = '\modules\managers\lib\Manager';

	protected $permissibleActions = array(
		'orders',
		'order',
		'add',
		'edit',
		'remove',
		'changePriority',
		'groupActions',
		'groupRemove',
		'getTemplateToAlertPartner',
		'ajaxAlertPartner',
		'partnerNotifyConfirm',
		'getActiveManagers',
		'getActivePartners',
		'getClientById',
		'getOrderGoodById',
		'getOrdersQuantityByStatusId',

		// Start: Categories Trait Methods
		'categories',
		'categoryAdd',
		'categoryEdit',
		'category',
		'removeCategory',
		'getMainCategories',
		'changeCategoriesPriority',
		//   End: Categories Trait Methods

		/* Start: Files Trait Methods*/
		'uploadFile',
		'addFilesFromEditPage',
		'removeFile',
		'setPrimary',
		'resetPrimary',
		'setBlock',
		'resetBlock',
		'editFile',
		'getTemplateToEditFile',
		'ajaxGetFilesBlock',
		'ajaxGetFilesListBlock',
		'getFileIcon',
		'download'
		/*   End: Files Trait Methods*/
	);

	protected $permissibleActionsForManagersUsers = array(
		'orders',
		'order',
		'edit',
		'getTemplateToAlertPartner',
		'getActiveManagers',
		'getActivePartners',
		'getClientById',
		'getOrderGoodById',
		'getOrdersQuantityByStatusId',
		/* Start: Files Trait Methods*/
		'uploadFile',
		'addFilesFromEditPage',
		'ajaxGetFilesBlock',
		'ajaxGetFilesListBlock',
		'getFileIcon',
		'download'
		/*   End: Files Trait Methods*/
	);

	protected $permissibleEditFieldsForPartnerManager = array(
		'statusId',
	);

	public function  __construct()
	{
		parent::__construct();
		$this->_config = new \modules\orders\lib\OrderConfig();
		$this->objectClass = $this->_config->getObjectClass();
		$this->objectsClass = $this->_config->getObjectsClass();
		$this->objectClassName = $this->_config->getObjectClassName();
		$this->objectsClassName = $this->_config->getObjectsClassName();

		if($this->isAuthorisatedUserAnManager())
			$this->permissibleActions = $this->permissibleActionsForManagersUsers;
	}

	protected function defaultAction()
	{
		return $this->orders();
	}

	protected function orders()
	{
		$this->checkUserRightAndBlock('orders');
		$this->rememberPastPageList($_REQUEST['controller']);

		$this->setObject($this->objectsClass);

		$start_date = (empty($this->getGET()['start_date'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['start_date']);
		$end_date = (empty($this->getGET()['end_date'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['end_date']);
		$categoryId = (empty($this->getGET()['categoryId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['categoryId']);
		$nr = (empty($this->getGET()['nr'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['nr']);
		$invoiceNr = (empty($this->getGET()['invoiceNr'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['invoiceNr']);
		$paymentOrderNr = (empty($this->getGET()['paymentOrderNr'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['paymentOrderNr']);
		$partnerNotified = (isset($this->getGET()['partnerNotified'])) ? '1' : 0;
		$city = (empty($this->getGET()['city'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['city']);
		$street = (empty($this->getGET()['street'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['street']);
		$home = (empty($this->getGET()['home'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['home']);
		$description = (empty($this->getGET()['description'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['description']);
		$itemsOnPage = (empty($this->getGET()['itemsOnPage'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['itemsOnPage']);
		$manager = (empty($this->getGET()['managerId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['managerId']);
		$partner = (empty($this->getGET()['partnerId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['partnerId']);
		$clientId = (empty($this->getGET()['clientId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['clientId']);
		$goodId = (empty($this->getGET()['goodId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['goodId']);
		$moduleId = (empty($this->getGET()['moduleId'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['moduleId']);
		$domain = (empty($this->getGET()['domain'])) ? '' : \core\utils\DataAdapt::textValid($this->getGET()['domain']);

		if (!empty($start_date))
			$this->modelObject->setSubquery('AND `date` >= ?d', \core\utils\Dates::convertDate($start_date));

		if (!empty($end_date))
			$this->modelObject->setSubquery('AND `date` <= ?d', \core\utils\Dates::convertDate($end_date));

		if (!empty($categoryId))
			$this->modelObject->setSubquery('AND `categoryId` = ?d', $categoryId);


		unset($this->getPOST()['statusIdArray']);
		if($this->getStatusIdArray()){
			$this->getPOST()['statusIdArray'] = $this->getStatusIdArray();
			$this->modelObject->loadWithRemovedObjects()->setSubquery('AND `statusId` IN ('.implode(',', $this->getPOST()['statusIdArray']).')');
		}
		else{
			$config = $this->_config;
			$this->modelObject->setSubquery('AND `statusId` != ?d', $config::CANCELED_STATUS_ID);
			$this->modelObject->setSubquery('AND `statusId` != ?d', $config::PERSENT_PAID_STATUS_ID);
		}

		if (!empty($nr))
			$this->modelObject->setSubquery('AND `nr` LIKE \'%?s%\'', $nr);

		if (!empty($invoiceNr))
			$this->modelObject->setSubquery('AND `invoiceNr` LIKE \'%?s%\'', $invoiceNr);

		if (!empty($paymentOrderNr))
			$this->modelObject->setSubquery('AND `paymentOrderNr` LIKE \'%?s%\'', $paymentOrderNr);

		if (!empty($partnerNotified))
			$this->modelObject->setSubquery('AND `partnerNotified` = ?d', $partnerNotified);

		if (!empty($city))
			$this->modelObject->setSubquery('AND `city` LIKE \'%?s%\'', $city);
		if (!empty($street))
			$this->modelObject->setSubquery('AND `street` LIKE \'%?s%\'', $street);

		if (!empty($home))
			$this->modelObject->setSubquery('AND `home` LIKE \'%?s%\'', $home);


		if (!empty($description))
			$this->modelObject->setSubquery('AND `description` LIKE \'%?s%\'', $description);

		if (!empty($manager))
			$this->modelObject->setSubquery('AND `managerId` = ?d', $manager);

		if (!empty($partner))
			$this->modelObject->setSubquery('AND `partnerId` = ?d', $partner);

		if (!empty($clientId)){
			$this->modelObject->setSubquery('AND `clientId` = ?d', $clientId);
		}

		if (!empty($goodId)){
			$this->modelObject->setSubquery('AND `id` IN (SELECT `orderId`  FROM `'.$this->getObject('\modules\orders\orderGoods\lib\OrderGoods')->mainTable().'` WHERE `goodId` = ?d)', $goodId);
		}

		if (!empty($moduleId)){
			$this->modelObject->setSubquery('AND `moduleId` = ?d', $moduleId);
		}

		if (!empty($domain)){
			$this->modelObject->setSubquery('AND `domain` = \'?s\'', $domain);
		}

		if($this->isAuthorisatedUserAnManager()){
			$this->modelObject->setSubquery('AND `partnerId` = ?d', $this->getAuthorizatedUser()->partnerId);
		}

		$this->modelObject->setOrderBy('`date` DESC, `id` DESC')->setPager($itemsOnPage);

		$this->setContent('objects', $this->modelObject)
			->setContent('pager', $this->modelObject->getPager())
			->setContent('pagesList', $this->modelObject->getQuantityItemsOnSubpageListArray())
			 ->includeTemplate($this->_config->getAdminTemplateDir().'orders'.$this->getOrderTemplateNameExtention());
	}

	private function getStatusIdArray()
	{
		$statusIdArray = array();
		foreach (explode('&', $_SERVER['QUERY_STRING']) as $element){
			if( strpos($element, 'statusId') !== false )
				$statusIdArray[] = \core\utils\DataAdapt::textValid(str_replace('statusId=', '', $element));
		}
		return empty($statusIdArray[0]) ? false : $statusIdArray;
	}

	protected function add()
	{
		$this->checkUserRightAndBlock('order_add');
		$objectId =  $this->setObject($this->_config->getObjectsClass())->modelObject->add($this->getPOST(), $this->modelObject->getConfig()->getObjectFields());
		if ($objectId){
			$this->setObject($this->_config->getObjectClass(), $objectId);
			$this->getObject($this->_config->getObjectClass(), $objectId)->mailNewOrderToManagers();
		}
		$this->ajax($objectId, 'ajax', true);
	}

	protected function edit()
	{
		$filteredPost = $this->isAuthorisatedUserAnManager() ? $this->filterPostFields() : $this->getPOST();
		$this->checkUserRightAndBlock('order_edit');
		$this->setObject($this->_config->getObjectClass(), (int)$this->getPOST()['id'])->ajax($this->modelObject->edit($filteredPost, $this->modelObject->getConfig()->getObjectFields()), 'ajax', true);
	}

	private function filterPostFields()
	{
		$post = array();
		$order = $this->getObject($this->_config->getObjectClass(), (int)$this->getPOST()['id']);
		foreach($this->_config->getObjectFields() as $key=>$value)
			if( in_array($key, $this->permissibleEditFieldsForPartnerManager))
				$post[$key] = $this->getPost()[$key];
			else
				$post[$key] = $order->$key;
		return $post;
	}

	protected function order()
	{
		$this->checkUserRightAndBlock('order');
		$this->useRememberPastPageList();

		$order = new \core\Noop();
		if (isset($this->getREQUEST()[0])){
			$order = $this->getObject($this->_config->getObjectClass(), $this->getREQUEST()[0]);
			if($this->isAuthorisatedUserAnManager())
				$this->checkPartnerRightForOrder($order->partnerId);
		}


		$tabs = array(
					'editOrder'.$this->getOrderTemplateNameExtention() => 'Параметры',
					'goodsOrder'=>'Товары',
					);

		$order->id ? $tabs = array_merge($tabs, array('files' => 'Файлы')) : '';

		$orders = new $this->objectsClass;
		$settings = new \core\Settings();
		$settings = $settings->getSettings('*', array('where' => array('query' => 'type="'.TYPE.'" OR type="all"')));

		$this->setContent('order', $order)
			->setContent('tabs', $tabs)
			->setContent('orders', $orders)
			->setContent('object', $order) // Need for files template
			 ->setContent('objects', $orders) // Need for files template
			->setContent('statuses', $orders->getStatuses())
			->setContent('mainCategories', $orders->getMainCategories(1))
			->setContent('activePartners', $this->getActivePartners())
			->setContent('activeManagers', $this->getActiveManagers())
			->setContent('client', $this->getClientById($order->clientId))
			->setContent('settingsRate', $settings['rate'])
			->includeTemplate($this->_config->getAdminTemplateDir().'order'.$this->getOrderTemplateNameExtention());
	}

	private function checkPartnerRightForOrder($partnerId)
	{
		$authorizatedManager = $this->getAuthorizatedManager();
		if( $authorizatedManager->isManagerBelongsToPartner($partnerId) )
			return $this;
		else{
			echo 'Access denied';
			throw new \exceptions\ExceptionAccess();
		}
	}

	private function getAuthorizatedManager()
	{
		return $this->getObject(self::MANAGER_USER_CLASS, $this->getAuthorizatedUser()->id);
	}

	protected function getActiveManagers()
	{
		$administrators = $this->getObject('\modules\administrators\lib\Administrators');
		return $administrators->getActiveManagers();
	}

	protected function getActivePartners()
	{
		$partners = $this->getObject('\modules\partners\lib\Partners');
		return $partners->getActivePartners();
	}

	protected function getClientById($clientId)
	{
		return $clientId ? $this->getObject('\modules\clients\lib\Client', $clientId) : $this->getNoop();
	}

	private function getOrderTemplateNameExtention()
	{
		return $this->isAuthorisatedUserAnManager() ? 'Manager' : '';
	}

	protected function getOrderGoodById($goodId)
	{
		return \modules\catalog\CatalogFactory::getInstance()->getGoodById($goodId);
	}

	protected function remove()
	{
		$this->checkUserRightAndBlock('order_delete');
		if (isset($this->getREQUEST()[0]))
			$orderId = (int)$this->getREQUEST()[0];
		if (!empty($orderId)) {
			$order = $this->getObject($this->objectClass, $orderId);
			$this->ajaxResponse($order->remove());
		}
	}

	protected function getTemplateToAlertPartner()
	{
		$this->checkUserRightAndBlock('order_getPartnerNotifyTemplate');
		$settings = new \core\Settings();
		$this->setContent('order', $this->getObject($this->objectClass, (int)$_REQUEST[0]))
			->setContent('time', date("d.m.y").'-'.date("H:i:s"))
			->setContent('adminEmail', $settings->getAllGlobalSettings()['admin_email'])
			->includeTemplate($this->_config->getAdminTemplateDir().'alertPartnerTemplate');
	}

	protected function ajaxAlertPartner()
	{
		$this->checkUserRightAndBlock('order_partnerNotifySend');
		$order = $this->getObject($this->objectClass, (int)$this->getPOST()['orderId']);
		$alert = new \modules\mailers\AlertPartner($order);
		$res = $alert->sendAlertPartner();
		if($res == 1)
			$this->addAlertToHistory($order);
		else
			$this->ajax(array('res'=>'error', 'message'=>'Произошла ошибка при попытке отправить оповещение партнеру. Обратитесь к разработчикам.', 'ajax'));
	}

	private function addAlertToHistory($order)
	{
		$contentToAddToHistory = $this->getContentToAddToHistory($order);
		$order->partnerNotifyHistory = $order->partnerNotifyHistory.$contentToAddToHistory;
		$order->partnerNotified	 = 0;
		$order->lastNotify = $this->getPost()['time'];

		$res = $order->edit();
		if($res == 1)
			$this->ajax(array('res'=>'ok', 'message'=>'Сообщение было успешно отправлено. История оповещений обновлена.', 'partnerHistory'=>$order->partnerNotifyHistory, 'ajax'), 'ajax');
		else
			$this->ajax(array('res'=>'error', 'message'=>'Произошла ошибка при попытке изменения истории оповещения партнера после отправки оповещения. Обратитесь к разработчикам.', 'ajax'));
	}

	private function getContentToAddToHistory($order)
	{
		ob_start();
			if($this->getPost()['aditionalMessage']){
				$this->setContent('aditionalMessage', $this->getPost()['aditionalMessage']);
			}
			$this->setContent('order', $order)
				->setContent('time', $this->getPost()['time'])
				->includeTemplate('alertPartnerMail');
			$contents = ob_get_contents();
		ob_end_clean();

		$managers = '';
		foreach($order->getPartner()->getManagers() as $manager )
			$managers = $managers.$manager->getLogin().', ';

		return '<br /><hr align="center" width="80%" size="2" color="black" /><br /><b>'.$this->getPost()['time'].'</b><br /> отправлено: '
						.$order->getPartner()->name.' ( '.$managers.' )'
						.$contents;
	}

	protected function partnerNotifyConfirm()
	{
		$order = $this->getObject($this->objectClass, (int)$this->getRequest()[0]);
		if( is_int( strpos($order->partnerNotifyHistory, $this->getRequest()[1]) ) )
			$this->addNotifyConfirmToHistory($order);
		else
			echo 'Извините, ваша ссылка не верна. Обязательно попробуйте пройти по высланной ссылке еще раз или подтвердите получение оповещения другим образом.';
	}

	private function addNotifyConfirmToHistory($order)
	{
		$order->partnerNotifyHistory = $order->partnerNotifyHistory
						.'<br /><hr align="center" width="80%" size="2" color="blue" /><br /><b>'.date("d.m.y").'-'.date("H:i:s").'</b><br /> Партнер '
						.$order->getPartner()->name.' подтвердил получение оповещение от '.$this->getRequest()[1].'<br />';

		if(empty($order->lastConfirmedNotify)){
			$order->partnerNotified	 = 1;
			$order->lastConfirmedNotify = $this->getRequest()[1];
		}
		else{
			if($this->getRequest()[1]  <= $order->lastConfirmedNotify){
				echo 'Извините, это оповещение уже было подтверждено.';
				return true;
			}
			else{
				$order->partnerNotified	 = 1;
				$order->lastConfirmedNotify = $this->getRequest()[1];
			}
		}

		$res = $order->edit();

		if($res ==1)
			echo 'Спасибо, вы успешно подтвердили получение оповещения партнера.';
		else
			echo 'Извините, подтверждение получения оповещения партнера не произошло. Обязательно попробуйте пройти по высланной ссылке еще раз или подтвердите получение оповещения другим образом.';
	}

	protected function getOrdersQuantityByStatusId($statusId)
	{
		if( ! $this->checkUserRight('orders'))
			return false;

		$orders = new $this->objectsClass;

		$where['query'] = 'mt.statusId=?d';
		$where['data'] = array($statusId);

		if($this->isAuthorisatedUserAnManager()){
			$partner = $this->getAuthorizatedManagerPartner();
			$where['query'] .= ' AND mt.partnerId=?d';

			$where['data'][] = $partner->id;
		}

		$filter = array('where' => $where);
		return $orders->countAll($filter);
	}

	private function getAuthorizatedManagerPartner()
	{
		$authorizatedManager = $this->getAuthorizatedManager();
		return $this->getObject('\modules\partners\lib\Partner', $authorizatedManager->partnerId);
	}

	public function printGoodTemplate($good)
	{
		$this->setContent('good', $good)
			 ->includeTemplate($good->getGood()->getPathToAdminOrderGoodTemplate());
	}
}
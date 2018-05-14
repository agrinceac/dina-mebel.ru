<?php
namespace controllers\base;
abstract class Controller
{
	use	\core\traits\controllers\Ajax,
		\core\traits\controllers\ServiceRequests,
		\core\traits\RequestHandler,
		\core\traits\Errors,
		\core\traits\ObjectPool;

	protected $action;
	protected $permissibleActions = array();

	public function __construct()
	{
		$this->setAction($this->getREQUEST()['action']);
	}

	public function __call($name, $arguments)
	{
		if (empty($name))
			return $this->defaultAction();
		elseif ($this->setAction($name)->isPermissibleAction())
			return $this->callAction($arguments);
		else
			return $this->redirect404();
	}

	protected function defaultAction()
	{
		$this->redirect404();
	}

	protected function setAction($action)
	{
		$this->action = $action;
		return $this;
	}

	protected function actionExists($actionName = null)
	{
		$actionName = isset($actionName) ? $actionName : $this->action;
		return method_exists($this, $actionName);
	}

	protected function isPermissibleAction($actionName = null)
	{
		$actionName = isset($actionName) ? $actionName : $this->action;
		return $this->actionExists($actionName) ? in_array($actionName, $this->permissibleActions) : false;
	}

	protected function callAction($arguments, $actionName = null)
	{
		$actionName = isset($actionName) ? $actionName : $this->action;
		return call_user_func_array(array($this, $actionName), $arguments);
	}

	protected function changePriority ()
	{
		$data = $this->getREQUEST()['data'];
		$counter = 0;
		foreach ($data as $objectId=>$priority) {
			$counter++;
			$this->setObject($this->_config->getObjectClass(), (int)$objectId)
				->modelObject->edit(array('id'=>$objectId, 'priority'=>$counter), array('id', 'priority'));
			$this->modelObject->getErrors();
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
					$data = new \core\ArrayWrapper($data);
					$this->setObject($object)->ajax($this->modelObject->edit($data), 'ajax', true);
				}
			}
	}

	private function groupRemove ()
	{
		if (empty($this->getPOST()['group']))
			echo $this->ajaxResponse(array('code'=>'2', 'message'=>'Выберите объекты для удаления!'));
		else {
			foreach($this->getPOST()['group'] as $key=>$objectId) {
				$object = $this->getObject($this->objectClass, $objectId);
				if ($object->delete())
					$result = true;
			}
			if ($result)
				echo $result;
			else
				echo $this->ajaxResponse(array('message' => 'Error! System can\'t delete objects!'));
		}
	}

	protected function rememberPastPageList($objectClass)
	{
		$sessionFilter = \core\SessionFilters::getInstance();
		$pastTypePage = \core\utils\DataAdapt::textValid($sessionFilter->get('pageType','type'));
		$pastUri = \core\utils\DataAdapt::textValid($sessionFilter->get($objectClass,'pastUri'));
		if($pastTypePage=='object'){
			header('Location: '.str_replace('amp;', '', $pastUri));
		}
		$sessionFilter->set($objectClass, array('pastUri'=>$_SERVER['REQUEST_URI']));
		$sessionFilter->set('pageType', array('type'=>'list'));
	}

	protected function useRememberPastPageList()
	{
		$sessionFilter = \core\SessionFilters::getInstance();
		$sessionFilter->set('pageType', array('type'=>'object'));
	}
}
<?php
namespace controllers\admin;
class IndexAdminController extends \controllers\base\Controller
{
	use 	\core\traits\controllers\Rights,
		\core\traits\controllers\Templates,
		\core\traits\controllers\Authorization;

	public function __call($name, $arguments)
	{
		if($_REQUEST['action'])
			return $this->redirect404();
		$this->showIndex();
	}

	private function showIndex ()
	{
		$this->includeTemplate(DIR.'modules/index/tpl/index');
	}
}
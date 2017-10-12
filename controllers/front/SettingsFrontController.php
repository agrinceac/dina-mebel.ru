<?php
namespace controllers\front;
class SettingsFrontController extends \controllers\base\Controller
{
	public function getSettingByName($name)
	{
		return $this->getObject('\core\Settings')->getAllGlobalSettings()[$name];
	}

}


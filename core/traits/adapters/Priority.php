<?php
namespace core\traits\adapters;
trait Priority
{
	protected function _adaptPriority($key)
	{
		$this->data[$key] = (int)$this->data[$key];
		if (!$this->data[$key]) {
			$row = db\Db::getMysql()->rowAssoc('SELECT MAX(`priority`) as `maxPriority` FROM `'.$this->mainTable.'`');
			$this->data[$key] = $row['maxPriority']++;
		}
	}
}
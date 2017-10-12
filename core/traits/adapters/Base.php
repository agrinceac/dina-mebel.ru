<?php
namespace core\traits\adapters;
trait Base
{
	public function _adaptHtml($key)
	{
		if (isset($this->data[$key]))
			$this->data[$key] = \core\utils\DataAdapt::textValid($this->data[$key]);
	}

	public function _adaptBool($key)
	{
		$this->data[$key] = (empty($this->data[$key])) ? 0 : 1;
	}

	public function _adaptUnset($key)
	{
		unset($this->data[$key]);
	}

	public function _adaptInt($key)
	{
		$this->data[$key] = (int)$this->data[$key];
	}

	protected function _adapt()
	{
		foreach ($this->dataVar as $key) {
			if (!empty($this->dataRules[$key]['adapt'])) {
				$rule = $this->dataRules[$key]['adapt'];
				$object = (method_exists($this->_moduleConfig, $rule)) ? $this->_moduleConfig : $this;
				$object->$rule($key);
			}
		}
		if (!empty($this->error))
			return false;
		return true;
	}

	protected function _beforeChange($arr, $dataVar = null, $dataRules = array())
	{
		return ($this->_beforeChangeWithoutAdapt($arr, $dataVar, $dataRules)) ? $this->_adapt() : false;
	}

	protected function _beforeChangeWithoutAdapt($arr, $dataVar = null, $dataRules = array())
	{
		$this->_setRules($dataRules)
			 ->_setDataVar($dataVar)
			 ->_setRelations();
		if (!$this->setData($arr))
			return false;
		if (!$this->_validation())
			return false;
		return true;
	}
}
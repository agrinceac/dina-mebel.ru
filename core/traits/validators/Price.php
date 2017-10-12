<?php
namespace core\traits\validators;
trait Price
{
	public function _validPrice($data)
	{
		if(!isset($data))
			return false;
		if(!is_numeric($data))
			return false;
		if($data <= 0)
			return false;

		return true;
	}

	public function _validCost($data)
	{
		if(!isset($data))
			return false;
		if(!is_numeric($data))
			return false;
		if($data < 0)
			return false;

		return true;
	}
}
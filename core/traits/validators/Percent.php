<?php
namespace core\traits\validators;
trait Percent
{
	public function _validPercent($data)
	{
		if(!isset($data))
			return false;
		if(!is_numeric($data))
			return false;
		if($data < 0)
			return false;
		if($data > 100)
			return false;

		return true;
	}
}
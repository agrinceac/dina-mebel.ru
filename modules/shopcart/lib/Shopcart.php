<?php
namespace modules\shopcart\lib;
class Shopcart implements \Iterator, \Countable
{
	use traits\ShopcartBaseMethods,
		\core\traits\Errors;

	static protected $instance = null;

	public static function getInstance()
	{
		if (is_null(self::$instance))
			self::$instance = new Shopcart();
		return self::$instance;
	}

	public function __construct()
	{
		$this->getGoodsFromCookie();
	}

	protected function getGoodsFromCookie()
	{
		$this->resetGoods();
		if (isset($_COOKIE[$this->cookieGoodsKey])) {
			try {
				foreach($this->getUnserializedCookie() as $good)
					$this->setShopcartGood($good['objectClass'], $good['objectId'], $good['quantity']);
			} catch (ShopcartException $e) {
				$this->getGoodsFromCookie();
			}
		}
		return $this;
	}

	protected function setShopcartGood($objectClass, $objectId, $quantity)
	{
		$elementKey = $this->getElementKey($objectClass, $objectId);
		$shopcartGood = $this->getGood($elementKey);
		if ($this-> isGoodInShopcart($objectClass, $objectId))
			$shopcartGood->setQuantity($shopcartGood->getQuantity()+$quantity);
		else
			$this->setGood($elementKey, new ShopcartGood($objectClass, $objectId, $quantity));
		return $this;
	}

	public function isGoodInShopcart($objectClass, $objectId)
	{
		$elementKey = $this->getElementKey($objectClass, $objectId);
		$shopcartGood = $this->getGood($elementKey);
		return is_object($shopcartGood);
	}

	public function addGood($objectClass, $objectId, $quantity)
	{
		$objectClass = (string)$objectClass;
		$objectId    = (int)$objectId;
		$quantity    = (int)$quantity;
		try {
			$this->checkObjectClass($objectClass)
				->checkObjectId($objectId)
				->checkQuantityForGood($quantity, $this->getObject($objectClass, $objectId))
				->setShopcartGood($objectClass, $objectId, $quantity)
				->updateCookie();
			return true;
		} catch (\exceptions\ExceptionShopcart $e) {
			$this->setError('quantity_'.$objectId, $e->getTextError());
			return $this->getErrors();
		}
	}

	public function getTotalPrice()
	{
		$totalPrice = 0;
		foreach ($this->getGoods() as $good)
			$totalPrice += $good->getTotalPrice();
		return $totalPrice;
	}
    
    public function getTotalPriceCredit()
	{
		$totalPrice = 0;
		foreach ($this->getGoods() as $good)
			if($good->getCategory()->credit==1)
                $totalPrice += $good->getTotalPrice();
		return $totalPrice;
	}

	public function getTotalQuantity()
	{
		$totalQuantity = 0;
		foreach ($this->getGoods() as $good)
			$totalQuantity += $good->getQuantity();
		return $totalQuantity;
	}

	public function resetShopcart()
	{
		return $this->resetGoods()->updateCookie();
	}

	public function removeGoodByCode($code)
	{
		$this->removeShopcartGoodByKey($code);
		return true;
	}

	/* Start: Iterator Methods */
	function rewind() {
		reset($this->getGoods());
//		reset($this->getSESSION()[$this->sessionsGoodsKey]);
	}

	function current() {
		return current($this->getGoods());
//		return current($this->getSESSION()[$this->sessionsGoodsKey]);
	}

	function key() {
		return key($this->getGoods());
//		return key($this->getSESSION()[$this->sessionsGoodsKey]);
	}

	function next() {
		next($this->getGoods());
//		next($this->getSESSION()[$this->sessionsGoodsKey]);
	}

	function valid() {
		return !!(current($this->getGoods()));
//		return !!(current($this->getSESSION()[$this->sessionsGoodsKey]));
	}
	/* End: Iterator Methods */

	/* Start: Countable Methods */
	function count()
	{
		return count($this->getGoods());
//		return count($this->getSESSION()[$this->sessionsGoodsKey]);
	}
	/* End: Countable Methods */

	public function isGoodsInShopcart()
	{
		return !!$this->count();
	}

}
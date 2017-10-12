<?php
namespace controllers\front;
class ShopcartFrontController extends \controllers\base\ShopcartBaseController
{
	use
		\core\traits\controllers\Meta,
		\core\traits\controllers\Templates,
		\core\traits\controllers\ControllersHandler,
		\core\traits\controllers\Breadcrumbs;

	protected $shopcartClass = '\modules\shopcart\lib\AuthorizatedShopcart';
	protected $shopcart;

	protected $permissibleActions = array(
		'shopcart',
		'ajaxAddGood',
		'ajaxGetShopcartBar',
		'ajaxRemoveGood',
		'ajaxGetShopcartGoodsTableContent',
		'getShopcartGoodsTableContent',
		'ajaxChangeQuantity',
		'ajaxResetShopcart',
		'getShopcart'
	);

	public function __construct()
	{
		$this->setExecutor();
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
		$this->shopcart();
	}

	private function setExecutor()
	{
		$shopcartClass = $this->shopcartClass;
		$this->shopcart = new $shopcartClass;
	}

	protected function shopcart()
	{
		$this->setMetaData('Оформление заказа', 'Оформление заказа', 'Оформление заказа')
			->setLevel('Корзина')
			->includeTemplate('/shopcart/shopcart');
	}

	private function setMetaData($title, $description, $keywords)
	{
		return $this->setTitle($title)
				->setDescription($description)
				->setKeywords($keywords);
	}

	protected function ajaxAddGood()
	{
		$post = new \core\ArrayWrapper($this->getPOST());
		$res = $this->shopcart->addGood($post->objectClass, $post->objectId, $post->quantity);
		$this->ajaxResponse( $res );
	}

	protected function ajaxGetShopcartBar()
	{
		ob_start();
		$this->includeTemplate('/shopcart/shopcartBar');
		$contents = ob_get_contents();
		ob_end_clean();
		echo $contents;
	}

	protected function ajaxRemoveGood()
	{
		$res = $this->removeGood($this->getPOST()['goodCode']);
		$this->ajaxResponse($res);
	}

	protected function removeGood($goodCode)
	{
		 return $this->shopcart->removeGoodByCode($goodCode);
	}

	protected function ajaxGetShopcartGoodsTableContent()
	{
		return $this->ajaxResponse( $this->getShopcartGoodsTableContent($this->getPOST()['template']) );
	}

	protected function getShopcartGoodsTableContent($template = null)
	{
		$template = $template ? $template : 'goodsTable';
		if($template == 'orderSent')
			$this->resetShopcart ();
		ob_start();
		$this->includeTemplate('/shopcart/'.$template);
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	protected function ajaxChangeQuantity()
	{
		$this->ajaxResponse( $this->changeQuantity() );
	}

	private function changeQuantity()
	{
		if($this->getPOST()['quantity'] > 0)
			$res = $this->shopcart->removeGoodByCode($this->getPOST()['goodCode']);
		else
			$res = 1;
		if($res == 1)
			$res = $this->shopcart->addGood($this->getPOST()['goodClass'], $this->getPOST()['goodId'], $this->getPOST()['quantity']);
		return $res;
	}

	protected function ajaxResetShopcart()
	{
		$this->resetShopcart();
		$this->ajaxResponse( 1 );
	}

	protected function resetShopcart()
	{
		$this->shopcart->resetShopcart();
	}

	protected function getShopcart()
	{
		return $this->shopcart;
	}
}
<?php
namespace controllers\front;
class OrderFrontController extends \controllers\base\Controller
{
	use	\core\traits\controllers\Templates,
		\core\traits\controllers\ControllersHandler;

	protected $permissibleActions = array(
		'ajaxSendOrder',
		'sendOrderByOneClick',
		'cacheOrderData',
		'getCachedOrderDataByName'
	);

	protected function ajaxSendOrder()
	{
		$feedback = new \modules\mailers\SendOrder($this->getPOST());
		$this->setObject($feedback);

		if($this->getPOST()['inCreditMark'] == 1)
			$res = $this->modelObject->sendOrderInCredit();
		else
			$res = $this->modelObject->sendOrder();


		if($res == 1)
//			unset($_SESSION['orderData']);
			$this->getController('Shopcart')->getShopcart()->resetShopcart();

		$this->setObject($feedback)->ajax($res, 'ajax');
	}

	protected function sendOrderByOneClick ()
	{
		$post = $this->getPOST();
		if ( $post->phoneNumber ) {
			$newOrderByOneClickMail = new \modules\mailers\OrderByOneClickMail();
			$result = $newOrderByOneClickMail->sendPhoneNumberToManagers($post->goodId, $post->phoneNumber);
		} else {
			$result = array( 'phoneNumber' => 'Пожалуйста введите свой номер телефона' );
		}
		$this->ajaxResponse($result);
	}

	protected function cacheOrderData()
	{
		foreach($_POST as $key=>$value)
			$_SESSION['orderData'][$key] = $value;
		$this->ajaxResponse(true);
	}

	protected function getCachedOrderDataByName($name)
	{
		return  !empty($_SESSION['orderData'][$name]) ? $_SESSION['orderData'][$name] : '';
	}
}

<?php
namespace modules\mailers;
class SendOrder extends \core\mail\MailBase
{
	use	\core\traits\validators\Base,
		\core\traits\controllers\ControllersHandler;

	function __construct($data)
	{
		parent::__construct();
		$this->templates = TEMPLATES.\core\url\UrlDecoder::getInstance()->getDomainAlias().'/'.$_REQUEST['lang'].'/emails/';
		$this->data = $data->getArray();
	}

	public function rules()
	{
		return array(
			'clientName, phone' => array(
				'validation' => array('_validNotEmpty', array('Ф.И.О.', 'Телефон')),
			),
			'email' => array(
				'validation' => array('_validEmail'),
			),
		);
	}

	public function sendOrder()
	{
		if (!$this->_beforeChange($this->data, array_keys($this->data)))
			return false;
		$res = $this->From($this->noreplyEmail)
				->To($this->adminEmail)
				->Bcc($this->bccEmail)
				->Subject('Новый заказ с сайта  '.SEND_FROM)
				->Content('data', $this->data)
				->Content('shopcart', $this->getController('Shopcart')->getShopcart())
				->BodyFromFile('order.tpl')
				->Send();
		return $res;
	}

	public function sendOrderInCredit()
	{
		if (!$this->_beforeChange($this->data, array_keys($this->data)))
			return false;
		$res = $this->From($this->noreplyEmail)
				->To($this->adminEmail)
				->Bcc($this->bccEmail)
				->Subject('Новая заявка на кредит с сайта  '.SEND_FROM)
				->Content('data', $this->data)
				->Content('shopcart', $this->getController('Shopcart')->getShopcart())
				->BodyFromFile('orderInCredit.tpl')
				->Send();
		return $res;
	}
}
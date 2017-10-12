<?php
namespace modules\mailers;
class OrderByOneClickMail extends \core\mail\MailBase
{
	use	\core\traits\RequestHandler,
		\core\traits\controllers\Authorization,
		\core\traits\ObjectPool;

	function __construct()
	{
		parent::__construct();
		$this->templates = TEMPLATES.\core\url\UrlDecoder::getInstance()->getDomainAlias().'/'.$_REQUEST['lang'].'/emails/mailOrderByOneClickTemplates/';
	}

	public function sendPhoneNumberToManagers($goodId, $clientPhoneNumber)
	{
		$managers = array($this->adminEmail);
		$good = new \modules\catalog\goods\lib\Good($goodId);
		$res = $this->From($this->noreplyEmail)
				->To($managers)
				->Bcc($this->bccEmail)
				->Subject('Клиент просит позвонить по номеру '.$clientPhoneNumber.', для оформления заказа на '.SEND_FROM)
				->Content('good', $good)
				->Content('clientPhoneNumber', $clientPhoneNumber)
				->Content('managers', $managers)
				->BodyFromFile('mailOrderByOneClickContent.tpl')
				->Send();
		if($res)
			return 1;
		throw new Exception('Error mail() in '.get_class($this).'!');
	}

}

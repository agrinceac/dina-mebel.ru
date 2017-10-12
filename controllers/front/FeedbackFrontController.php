<?php
namespace controllers\front;
class FeedbackFrontController extends \controllers\base\Controller
{
	use \core\traits\controllers\Templates;

	protected $permissibleActions = array(
		'ajaxSendMessage'
	);

	public function __construct()
	{
		parent::__construct();
	}

	protected function ajaxSendMessage()
	{
		$feedback = new \modules\mailers\ContactsFeedback($this->getPOST());
		$this->setObject($feedback)
			->ajax($this->modelObject->sendFeedbackMail(), 'ajax');
	}

	protected function redirect404()
	{
		echo '404';
	}
}

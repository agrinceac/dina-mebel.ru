<?php
namespace core\traits\validators;
trait Captcha
{
	protected function _validCorrectCaptcha($data)
	{
		$captcha = new \core\captcha\CaptchaString();
		if (!$captcha->checkCaptcha($data)) {
			$this->setError('captcha');
		}
		return true;
	}
}
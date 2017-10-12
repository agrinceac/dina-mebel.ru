<?php
namespace core\captcha;
class CaptchaString
{
	public function generate()
	{
		$signs = array('+', '-');
		$num1 =  mt_rand(1,9);
		$num2 =  mt_rand(1,9);
		$sign =  $signs[array_rand($signs)];

		if($sign == '+')
			$result = max($num1, $num2) + min($num1, $num2);
		else
			$result = max($num1, $num2) - min($num1, $num2);

		$_SESSION['captchaString'] = max($num1, $num2) . ' ' . $sign . ' ' . min($num1, $num2) . ' = ';
		$_SESSION['captcha'] = $result;

		return $_SESSION['captchaString'];
	}

	public function checkCaptcha($data)
	{
		$data = trim($data);
		if ($data === ''  or !is_numeric($data) or !isset($_SESSION['captcha']))
			return false;
		return ((int)$data === (int)$_SESSION['captcha']);
	}

}
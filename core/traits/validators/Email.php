<?php
namespace core\traits\validators;
trait Email
{
	public function _validEmail($data, $settings = array())
	{
		$settings['key'] = (empty($settings['key'])) ? 'email' : $settings['key'];
		if (empty($data) && !empty($settings['notEmpty'])) {
			$this->errors[$settings['key']] = $this->getErrorsList()['email_empty'];
			return 'error_add';
		}
		if (!empty($data) && !\core\utils\Utils::isEmail($data)) {
			$this->errors[$settings['key']] = $this->getErrorsList()['email_invalid'];
			return 'error_add';
		}
		return true;
	}

    public function _validMultiEmails($data, $settings = array())
    {
        if(empty($data))
            return $this->_validEmail($data, $settings);

        $emailsArray = explode(',', str_replace(' ', '', $data));
        foreach ($emailsArray as $email){
            $this->_validEmail($email, $settings);
            if($this->_validEmail($email, $settings) !== true)
                return $this->errors[$settings['key']] = $this->getErrorsList()['multi_emails_invalid'];;
        }
        return true;
    }
}
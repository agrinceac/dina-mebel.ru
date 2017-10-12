<?php
namespace core\mail;
abstract class MailBase extends \core\Model{

	protected $templates = '';
	protected $content   = '';
	protected $data      = '';

	private $adminEmail   = '';
	private $bccEmail   = '';
	private $noreplyEmail   = '';
	private $subjects   = '';

	private $to          = array();
	private $copy        = array();
	private $bcc         = array();
	private $from        = '';
	private $subject     = '';
	private $body        = '';

	private $priorities  = array(
								'1' => 'Highest',
								'2' => 'High',
								'3' => 'Normal',
								'4' => 'Low',
								'5' => 'Lowest'
							);

	private $charset     = "UTF-8";
	private $encoding    = "8bit";
	private $receipt     = false;
	private $contentType ='text/html';

	private $fullBody    = '';
	private $boundary    = '';
	private $headers     = '';
	private $attach      = array();

	public function reset() {
		$this->to      = array();
		$this->copy    = array();
		$this->bcc     = array();
		$this->from    = '';
		$this->subject = '';
		$this->body    = '';
		$this->headers = '';
		$this->boundary    = '';
		$this->attach      = array();

		return $this;
	}

	public function __construct()
	{
		$settings = new \core\Settings();
		$settings = $settings->getSettings('*', array('where' => array('query' => 'type="'.TYPE.'" OR type="all"')));
		$this->adminEmail = $settings['admin_email'];
		$this->bccEmail = $settings['bcc_email'];
		$this->noreplyEmail = $settings['noreply_email'];
		$this->subjects = \core\Configurator::getInstance()->getArrayByKey('mail_subjects');
		$this->boundary = '--'. md5( uniqid('myboundary') );
	}

	public function __set($name, $value)
	{
		$method = 'set'.ucfirst($name);

		if ($this->isMethod($method))
			$this->$method($value);
		elseif ($this->isProperty($name))
			$this->$name = $value;
		else
			throw new \Exception ('Error! Arguments in method __set() in class MailerBase is a wrong');
	}

	private function isMethod ($value)
	{
		return method_exists($this, $value);
	}

	private function isProperty($value)
	{
		return property_exists($this, $value);
	}

	private function setTo($value)
	{
		if (is_string($value))
			 $value = explode (',', str_replace(' ', '', $value));

		if (is_array($value))
			foreach($value as $to)
				$this->to[] = $to;
	}

	private function setCopy($value)
	{
		if (is_string($value))
			 $value = explode (',', str_replace(' ', '', $value));

		foreach($value as $copy)
			$this->copy[] = $copy;
	}

	private function setBcc($value)
	{
		if (is_string($value))
			 $value = explode (',', str_replace(' ', '', $value));

		foreach($value as $bcc)
			$this->bcc[] = $bcc;
	}

	public function __get($name)
	{
		if ($this->isProperty($name))
			return $this->$name;
		else
			throw new \Exception ('Error! Property '.$name.' has not found in class MailerBase', 1024);
	}

	public function To($value)
	{
		$this->__set('to', $value);
		return $this;
	}

	public function Copy($value)
	{
		$this->__set('copy', $value);
		return $this;
	}

	public function Bcc($value)
	{
		$this->__set('bcc', $value);
		return $this;
	}

	public function From($value)
	{
		$this->__set('from', $value);
		return $this;
	}

	public function Subject($value)
	{
		$this->__set('subject', $value);
		return $this;
	}

	public function Content($varName, $content)
	{
		$this->content[$varName] = $content;
		return $this;
	}

	public function Body($value)
	{
		$this->__set('body', $value);
		return $this;
	}

	protected function BodyFromFile ($fileName) {
		$this->Body($this->getBodyFromFile($fileName));
		return $this;
	}

	protected function getBodyFromFile ($fileName) {
		if ($this->content)
			foreach ($this->content as $key => $value)
				$$key = $value;
		ob_start();
		include($this->templates.$fileName);
		$body = ob_get_contents();
		ob_end_clean();
		return $body;
	}

	public function Receipt()
	{
		$this->__set('receipt', true);
		return $this;
	}

	public function Send()
	{
		$this->_beforeSend();

		$res = mail($this->to, $this->subject, $this->fullBody, $this->headers);

		if (  $res )
			return true;

		return false;
	}

	public function Show()
	{
		$this->_beforeSend();

		echo $this->fullBody;
	}

	private function _beforeSend()
	{
		$this->to = (sizeof($this->to)>0) ? implode(',', $this->to) : '' ;

		$this->headers['From'] = $this->from;
		if ((sizeof($this->copy)>0))
			$this->headers['CC'] = implode(',', $this->copy);

		if (sizeof($this->bcc) > 0)
			$this->headers['BCC'] = implode(',', $this->bcc);

		if( $this->receipt ) {
			$this->headers["Disposition-Notification-To"] = $this->from;
        }

		$this->headers["Mime-Version"] = "1.0";
		$this->headers["Content-Type"] = $this->contentType.'; charset='.$this->charset;
		$this->headers["Content-Transfer-Encoding"] = $this->encoding;
        $this->headers["X-Mailer"] = 'PHP/' . phpversion();

        if( sizeof($this->attach)> 0 ) {
			$this->_buildMailWithAttachement();
        } else {
			$this->_buildMail();
        }

		$this->headersToString();
	}

	function _buildMailWithAttachement()
	{
		$this->headers['Content-Type'] = "multipart/mixed;\n boundary=\"$this->boundary\"";
		$this->fullBody .= "\n\nThis is a multi-part message in MIME format.\n--$this->boundary\n";
		$this->fullBody .= "Content-Type: text/html; charset=$this->charset\nContent-Transfer-Encoding: $this->encoding\n\n$this->body\n";
		$separator= chr(13).chr(10);
		$this->fullBody .= implode($separator, $this->attach);
		$this->fullBody .= "\n--".$this->boundary."--";
	}

	private function _buildMail()
	{
		$this->fullBody = $this->body;
	}

	private function headersToString()
	{
		$headString = '';
		foreach($this->headers as $key=>$value)
			$headString .= "$key: $value\n";

		$this->headers = $headString;
	}

	function attach($file, $filetype = "", $disposition = "inline")
	{
		if(is_array($file)){
			$tmp = $file;
			$file = $tmp['filePath'];
			$fileName = $tmp['fileName'];
		}

		if(empty($filetype))
			$filetype = "application/x-unknown-content-type";

		if( ! file_exists($file) )
			trigger_error('Class Mail, method attach : file '.$file.' can\'t be found', E_USER_NOTICE);

		$basename = basename($file);
		$fileName = isset($fileName) ? $fileName : $basename;
		$subhdr= "--$this->boundary\nContent-Type: $filetype;\n name=\"$basename\";\nContent-Transfer-Encoding: base64\nContent-Disposition: $disposition;\n  filename=\" $fileName  \"\n\n";

		$file = $this->getFileContent($file);

		$this->attach[] = $subhdr.$file;

		return $this;
	}
	function BodyImage($file, $filetype = "image/jpeg")
	{
		if(!strpos($filetype, 'image'))
			trigger_error('Error! In method BodyImage has been transfered not Image', E_USER_NOTICE);

		if( ! file_exists($file) )
			trigger_error('Class Mail, method attach : file '.$file.' can\'t be found', E_USER_NOTICE);

		$basename = basename($file);
		$anchor = str_replace('.jpeg','', str_replace('.jpg','', str_replace('.png','', $basename)));
		$subhdr= "--$this->boundary\nContent-Type: $filetype; name=\"$basename\" \nContent-Transfer-Encoding:base64 \nContent-ID: <$anchor> \n\n";

		$file = $this->getFileContent($file);

		$this->attach[] = $subhdr.$file."\n";

		return $this;
	}

	private function getFileContent($fileName)
	{
		$linesz= filesize($fileName)+1;
		$fp= fopen( $fileName, 'r' );
		$file = chunk_split(base64_encode(fread( $fp, $linesz)));
		fclose($fp);

		return $file;
	}

	function resetAttachment()
	{
		$this->attach = array();

	}

	function Priority( $priority )
	{
        if( !is_int($priority) || !isset($this->priorities[$priority]))
			throw new \Exception('Error! Invalid value of Property has been transfered in MailerBase', 1024);

        $this->headers["X-Priority"] = $this->priorities[$priority];

        return true;
	}

	protected function resetMail() {
		$this->to      = array();
		$this->bcc      = array();
		$this->copy    = array();
		$this->from    = '';
		$this->subject = '';
		$this->body    = '';
		$this->headers = '';

		return $this;
	}

}
?>
<?php
namespace core\utils;
class Utils
{
	use \core\traits\RequestHandler;

	// return full current link with $data add
	public static function getFullLink($data = null)
	{
		$link = "http://".$this->getSERVER()['SERVER_NAME'].$this->getSERVER()['REQUEST_URI'];
		if (!isset($data)) return $link;
		if (!empty($this->getSERVER()['QUERY_STRING'])) $link .= '&'.$data;
		else $link .= '?'.$data;
		return $link;
	}

	static public function trimUcWords($value) {
		return str_replace(' ', '', ucwords($value));
	}

	public static function removeLinkQueryParts($remove_parts)
	{
		$parts = explode('&',$this->getSERVER()['QUERY_STRING']);
		$remove_parts = explode(',',$remove_parts);
		$parts_new = array_udiff($parts, $remove_parts,"\core\utils\Utils::compareFunc");
		$link = $this->getSERVER()['PHP_SELF'].'?';
		foreach ($parts_new as $parts) {
			if (!empty($parts)) $link .= $parts.'&';
		}
		$link = substr($link,0,-1);
		return $link;
	}

	private static function compareFunc($a, $b)
	{
		if (preg_match("/($b)=[^&]*/",$a)) return 0;
		return ($a > $b)? 1:-1;
	}

	public static function daysToUnix($data)
	{
		return $data * 86400 ;
	}

	public static function daysFromUnix($data)
	{
		return $data / 86400 ;
	}

	public static function isEmail($email)
	{
		return (!empty($email) && preg_match("/^[a-z0-9\._-]+@[a-z0-9\._-]+\.[a-z]{2,4}$/i", $email)) ? true : false;
	}

	public static function translit($str)
	{
		$tr = array(
			"А"=>"A", "Б"=>"B", "В"=>"V", "Г"=>"G", "Д"=>"D", "Е"=>"E", "Ж"=>"J", "З"=>"Z",
			"И"=>"I", "Й"=>"Y", "К"=>"K", "Л"=>"L", "М"=>"M", "Н"=>"N",	"О"=>"O", "П"=>"P",
			"Р"=>"R", "С"=>"S", "Т"=>"T", "У"=>"U", "Ф"=>"F", "Х"=>"H", "Ц"=>"TS","Ч"=>"CH",
			"Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"","Э"=>"E",
			"Ю"=>"YU","Я"=>"YA",
			"а"=>"a", "б"=>"b", "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ж"=>"j", "з"=>"z",
			"и"=>"i", "й"=>"y", "к"=>"k", "л"=>"l", "м"=>"m", "н"=>"n",	"о"=>"o", "п"=>"p",
			"р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", "х"=>"h", "ц"=>"ts","ч"=>"ch",
			"ш"=>"sh","щ"=>"sch","ъ"=>"y","ы"=>"yi","ь"=>"","э"=>"e",
			"ю"=>"yu","я"=>"ya",
			" "=>"_", "/"=>"_/_", "%"=>"_prcnt_", "?"=>"_qstn_", "("=>"_", ")"=>"_", "'"=>"", "№"=>"_nr_"
		);
		return strtr($str,$tr);
	}

	public static function getDistinctFileSize($fileSize)
	{
		$arr = array ("b", "Kb", "Mb", "Gb", "Tb");
		$step=0;
		while ($fileSize>=1024){
			$fileSize/=1024;
			$step++;
		}
		return round ($fileSize, 2).' '.$arr[$step];
	}

	public static function removeGetString($url)
    {
        return strtok($url, '?');
    }
}
?>
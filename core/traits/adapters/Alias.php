<?php
namespace core\traits\adapters;
trait Alias
{
	private $deniedSimbols = array(
		'<',
		'>' ,
		'«',
		'»',
		'№',
		'+',
		',',
		'\'',
		'&quot;',
		'!',
		'@',
		'#',
		'$',
		'%',
		'^',
		'&',
		'*',
		'=',
		'`',
		'~',
		':',
		';',
	);

	private $replaceWithUnderscoreSimbols = array(
		' ',
	);

	public function _adaptAlias($key)
	{
		$this->_generateAlias($key);
	}

	private function _generateAlias($key)
	{
		$translitName = ($this->data[$key]) ? $this->data[$key] : \core\utils\Utils::translit($this->data['name']) ;
		$isExists = (!empty($this->data[$this->idField])) ? false : (( \core\db\Db::getMySql()->isExist($this->mainTable(),  $key, $translitName) ));
		if ( $isExists )
			$this->data[$key] = $this->_transformAlias(preg_replace("|[^\d\w ]-+|i", "", $translitName), $key);
		else {
			$this->data[$key] = preg_replace("|[^\d\w ]-+|i", "", $translitName);
		}
		$this->data[$key] = str_replace ($this->deniedSimbols, '', lcfirst($this->data[$key]) );
		$this->data[$key] = str_replace ($this->replaceWithUnderscoreSimbols, '_', lcfirst($this->data[$key]) );
	}

	private function _transformAlias($alias, $key)
	{
		do {
			$array = explode('_', $alias);
			if (count($array) > 1) { // $alias already contains '_' char in it
				$last = array_pop($array);
				if( preg_match('/^\d+$/', $last) ) { // if $last has numerical presentation
					$alias = implode('_', $array) . '_' . ($last+1);
				} else {
					$alias .= '_1';
				}
			} else {
				$alias .= '_1';
			}
		} while( \core\db\Db::getMySql()->isExist($this->mainTable(),  $key, $alias));

		return $alias;
	}

	public function _adaptAliasUnique($key)
	{
		$this->_generateAliasUnique($key);
	}

	private function _generateAliasUnique($key)
	{
		$translitName = ($this->data[$key]) ? $this->data[$key] : \core\utils\Utils::translit($this->data['name']) ;
		$isExists = (!empty($this->data[$this->idField])) ? false : (( \core\db\Db::getMySql()->isExist($this->mainTable(),  $key, $translitName) ));
		if ( $isExists ){
			$settings['key'] = (empty($settings['key'])) ? $key : $settings['key'];
			$this->errors[$settings['key']] = $this->errorsList['not_unique'];
			return 'error_add';
		}
		else {
			$this->data[$key] = $translitName;
		}
		$this->data[$key] = str_replace ($this->deniedSimbols, '', lcfirst($this->data[$key]) );
		$this->data[$key] = str_replace ($this->replaceWithUnderscoreSimbols, '_', lcfirst($this->data[$key]) );
	}
}

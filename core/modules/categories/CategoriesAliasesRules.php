<?php
namespace core\modules\categories;
class CategoriesAliasesRules
{
	private $rules = array(
		'/igrovie_konstrukcii/' => '/',
	);
	
	public function useRules($alias)
	{
		return str_replace(array_keys($this->rules), array_values($this->rules), $alias);
	}
}
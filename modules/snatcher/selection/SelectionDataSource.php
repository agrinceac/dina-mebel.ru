<?php
namespace modules\snatcher\selection;

class SelectionDataSource
{
    private static
        $instance = null;

    /**
     * @var array['dina-mebel.ru'] array Mandatory element. Defines the options for dina-mebel.ru domain snatch
     * @var array['dina-mebel.ru']['categoriesOnCategoryPage] array Mandatory element. The title represents the alias of snatching
     * @var array['fields']['categoriesOnCategoryPage]['title'] string Mandatory element. Title of snatching
     * @var array['fields']['categoriesOnCategoryPage]['objectConfig'] string Mandatory element.
     *      Config class of objects on page for snatching (ex. Category or CatalogItem)
     * @var array['fields']['categoriesOnCategoryPage]['categoryMemberConfig'] string Optional element.
     *      Config class of objects which category consists of on page for snatching (ex. CatalogItem)
     *      This variable needs only in case when the config class is not really known. Ex. category.
     */
    private static $source = array(
        'dina-mebel.ru' => array(
            'categoriesOnCategoryPage' => array(
                'title' => 'Категории на стр. категории',
                'objectConfig' => 'core\modules\categories\CategoryConfig',
                'categoryMemberConfig' => 'modules\catalog\goods\lib\GoodConfig'
            ),
            'hitGoodsOnIndexPage' => array(
                'title' => 'Хиты продаж на главной',
                'objectConfig' => 'modules\catalog\goods\lib\GoodConfig'
            ),
            'slyderGoodsOnIndexPage' => array(
                'title' => 'Слайдер на главной',
                'objectConfig' => 'modules\catalog\goods\lib\GoodConfig'
            )
        )
    );

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {}

    private function __construct() {}

    public function getSource()
    {
        return self::$source;
    }

    public function getDomainAliasesArray()
    {
        $array = array();
        foreach (self::getSource() as $key => $value)
            if(!empty($value))
                $array[] = $key;
        return $array;
    }

    public function getSelectionAliasesArray($domain)
    {
        $array = array();
        foreach (self::getSource()[$domain] as $key => $value)
            if(!empty($value))
                $array[$key] = $value;
        return $array;
    }
}
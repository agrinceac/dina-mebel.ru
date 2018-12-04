<?php
namespace controllers\admin;

use modules\snatcher\lib\Snatcher;
use modules\snatcher\priority\lib\Priority;
use modules\snatcher\selection\Selection;
use modules\snatcher\selection\SelectionDataSource;

class PriorityAdminController extends \controllers\base\Controller
{
    use	\core\traits\controllers\Rights,
        \core\traits\controllers\Templates,
        \core\traits\RequestHandler,
        \core\traits\controllers\Authorization;

	protected $permissibleActions = array(
        'update'
    );

    public function  __construct()
    {
        $this->checkUserRightAndBlock('goods');
        parent::__construct();
    }

    protected function defaultAction()
    {
        return $this->priority();
    }

	private function priority()
	{
	    if($this->getGET()['domainAlias'])
	        $this->setContent(
	            'selectionAliasesArray',
                SelectionDataSource::getInstance()->getSelectionAliasesArray($this->getGET()['domainAlias'])
            );

        if($this->getGET()['domainAlias'] && $this->getGET()['selectionAlias'] && $this->getGET()['url']){
            $selection = new Selection($this->getGET()['domainAlias'], $this->getGET()['selectionAlias']);
            $objects = Snatcher::getInstance()->setSelection($selection)
                                                ->getObjects($this->getGET()['url']);

            $this->setContent('objects', $objects);
        }

		$this->setContent('domainAliasesArray', SelectionDataSource::getInstance()->getDomainAliasesArray())
            ->includeTemplate(DIR.'modules/snatcher/priority/tpl/priority');
	}

	protected function update()
    {
        $res = (new Priority())->set(
            $this->getPost()['url'],
            $this->getPost()['selectionAlias'],
            $this->getPost()['objectConfig'],
            $this->getPost()['data']
        );
        echo $res;
    }
}

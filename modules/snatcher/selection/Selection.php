<?php
namespace modules\snatcher\selection;

class Selection
{
    private $data,
            $domainAlias,
            $alias,
            $title,
            $objectConfig,
            $categoryMemberConfig;

    public function __construct($domainAlias, $alias)
    {
        $dataSource = SelectionDataSource::getInstance()->getSource()[$domainAlias][$alias];
        if(!empty($dataSource))
            $this->data = SelectionDataSource::getInstance()->getSource()[$domainAlias][$alias];
        else
            throw new \Exception('Error while trying to set dataSource in '.__CLASS__);

        $this->setDomainAlias($domainAlias)
            ->setAlias($alias)
            ->setTitle()
            ->setObjectConfig()
            ->setCategoryMemberConfig();
    }

    private function setDomainAlias($domainAlias)
    {
        $this->domainAlias = $domainAlias;
        return $this;
    }

    private function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    private function setTitle()
    {
        if(isset($this->data['title']) && !empty($this->data['title']))
            $this->title = $this->data['title'];
        else
            throw new \Exception('Error while trying to set title in '.__CLASS__);
        return $this;
    }

    private function setObjectConfig()
    {
        if(isset($this->data['objectConfig']) && !empty($this->data['objectConfig']))
            $this->objectConfig = $this->data['objectConfig'];
        else
            throw new \Exception('Error while trying to set objectConfig in '.__CLASS__);
        return $this;
    }

    private function setCategoryMemberConfig()
    {
        if(isset($this->data['categoryMemberConfig']) && !empty($this->data['categoryMemberConfig']))
            $this->categoryMemberConfig = $this->data['categoryMemberConfig'];
        return $this;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getObjectConfig()
    {
        return $this->objectConfig;
    }

    public function getCategoryMemberConfig()
    {
        if(isset($this->categoryMemberConfig) && !empty($this->categoryMemberConfig))
            return $this->categoryMemberConfig;
        else
            throw new \Exception('No categoryMemberConfig is set for '.$this->domainAlias.'->'.$this->title.' in '.__CLASS__);
    }
}
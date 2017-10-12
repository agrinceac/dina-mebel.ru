<?php
namespace core\traits\controllers;
trait Meta
{
	private $metaTitle;
	private $metaKeywords;
	private $metaDescription;

	protected function getMetaTitle()
	{
		return $this->getMeta('metaTitle');
	}

	protected function getMetaDescription()
	{
		return $this->getMeta('metaDescription');
	}

	protected function getMetaKeywords()
	{
		return $this->getMeta('metaKeywords');
	}

	private function getMeta($name)
	{
		return ($this->$name) ? $this->$name : $this->getDefaultMeta($name);
	}

	private function getDefaultMeta($name)
	{
		return $this->getObject('\core\Settings')->getAllGlobalSettings()[$name];
	}

	protected function setTitle($data)
	{
		return $this->setMeta('metaTitle', $data);
	}

	protected function setDescription($data)
	{
		return $this->setMeta('metaDescription', $data);
	}

	protected function setKeywords($data)
	{
		return $this->setMeta('metaKeywords', $data);
	}

	private function setMeta($metaName, $metaData)
	{
		$this->$metaName = $metaData;
		return $this;
	}

	protected function setMetaFromObject($object)
	{
		if ($object instanceof \interfaces\IObjectToFrontend)
			return $this->setTitle($object->getMetaTitle())
						->setDescription($object->getMetaDescription())
						->setKeywords($object->getMetaKeywords());
		throw new \Exception('Object '.get_class($object).' was not implement interface IObjectToFrontend in '.get_class($this).'!');
	}
}
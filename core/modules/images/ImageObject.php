<?php
namespace core\modules\images;
class ImageObject extends \core\modules\base\ModuleObject
{
	protected $configClass = '\core\modules\images\ImageConfig';

	function __construct($objectId, $configObject)
	{
		parent::__construct($objectId, new $this->configClass($configObject));
	}

	public function delete()
	{
		$file = new \core\files\uploader\File($this->getPath());
		$file->delete();
		return ( parent::delete() ) ? (int)$this->id : false ;
	}

	public function getParentObjectConfig()
	{
		return $this->getConfig()->getParentConfig();
	}

	public function getPath()
	{
		$config = $this->getParentObjectConfig();
//		var_dump(get_class($config));
		$config = $config->getParentConfig()->getConfig();
		if(file_exists(DIR.$config->imagesPath.$this->id.'.'.$this->extension))
			return DIR.$config->imagesPath.$this->id.'.'.$this->extension;
		else
			return NO_IMAGE_FILE_PATH;
	}

	public function getImage($resize = null, $watermark = null)
	{
		$watermarkObject = new \core\images\resize\Watermark();
		if(in_array($resize, $watermarkObject->getWatermarkTypes())){
			$watermark = $resize;
			$resize = null;
		}

		if (!$this->validResizeString($resize)) {
			throw new \Exception('Resize arguments are not valid!');
		}
		$resolution = ($resize) ? $resize :'0x0';

		$cache = new \core\images\resize\Cache();
		$fileNameInCache = $cache->getImagePath($this, $resolution, $watermark);
		return $fileNameInCache;
	}
	
	public function getFocusImage($resize = null, $watermark = null)
	{
		$watermarkObject = new \core\images\resize\Watermark();
		if(in_array($resize, $watermarkObject->getWatermarkTypes())){
			$watermark = $resize;
			$resize = null;
		}

		if (!$this->validResizeString($resize)) {
			throw new \Exception('Resize arguments are not valid!');
		}
		$resolution = ($resize) ? $resize :'0x0';

		$cache = new \core\images\resize\Cache();
		$fileNameInCache = $cache->getImagePath($this, $resolution, $watermark, true);
		return $fileNameInCache;
	}

	private function validResizeString($resize = null)
	{
		if ($resize) {
			$values = explode('x', $resize);
			return (sizeof($values) == 2);
		}
		return true;
	}

	public function isPrimary()
	{
		return ((int)$this->categoryId === 2);
	}

	public function isBlocked()
	{
		return ((int)$this->statusId === 2);
	}
}
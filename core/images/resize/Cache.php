<?php
namespace core\images\resize;
class Cache
{
    const CACHE_DIR = '/cache';

    protected function getCacheImageBaseUrl($imagesUrl)
    {
        $imageBaseUrl = self::CACHE_DIR . '/' .
        str_replace('data/','',$imagesUrl);
        return $imageBaseUrl;
    }

    protected function getSizesFromResolution($resolution)
    {
        $resolutions = explode('x', $resolution);
        $width = ($resolutions[0] == '') ? '0' : $resolutions[0];
        $height = ($resolutions[1] == '') ? '0' : $resolutions[1];
        return array($width, $height);
    }


    protected function getImagesUrl( $image) {
        $config = $image->getParentObjectConfig()->getParentConfig()->getConfig();
        return $config->imagesUrl;
    }

	public function getImagePath( $image, $resolution = null, $watermark = null, $focus = false)
	{
		$alias = $image->alias;
		$extension = $image->extension;
		$origFileName = $image->getPath();

		$resolution = $resolution ? $resolution : getimagesize($origFileName)[0].'x'.getimagesize($origFileName)[1];
		list($width, $height) = $this->getSizesFromResolution($resolution);
		$imagesUrl = $this->getImagesUrl($image);
		$imagePath = $this->getCacheImageBaseUrl($imagesUrl) . 
					 $width.'x'.$height .
					 (empty($focus) ? '' : '_focus') .
					 (empty($watermark) ? '' : '_watermark');
		$imageFile = $alias . '.' . $extension;

		if (!file_exists(DIR . $imagePath . '/' . $imageFile)) { // если файла нет в кеше - создаем его
			 if (!(file_exists(DIR . $imagePath) && is_dir(DIR . $imagePath))) {
				 $this->makeDirs($imagePath);
			 }
			 $resizer = new ImageResizer();
			 $resizer->resizeToFile($origFileName, DIR . $imagePath . '/' . $imageFile, $width, $height, $watermark, $focus);
		}
		return $imagePath . '/' . $imageFile;
	}

    private function makeDirs($dir)
    {
        \core\utils\Directories::makeDirsRecusive($dir);
		return $this;
    }

    public function clearAll()
    {
        $this->_deleteDir(DIR . self::CACHE_DIR);
    }

    protected function _deleteDir($dir)
    {
        $handle = opendir($dir);
        if (!$handle) return;
        while (false !== ($fname = readdir($handle))) {
              if (is_dir( $dir . '/' . $fname)) {
                 if (($fname != '.') && ($fname != '..')) {
                    $this->_deleteDir( $dir .'/' . $fname);
                 }
              } else {
                 unlink( $dir .'/' . $fname);
              }
        }
        closedir($handle);
        if($dir != DIR . self::CACHE_DIR) {
             rmdir($dir);
        }
    }

//==
// удаление закешированных изображений для заданного объекта ImageObject
// НЕ ТЕСТИРОВАНО !
    public function clearImageFiles(ImageObject $image)
    {
        $imagesUrl = $this->getImagesUrl($image);
        $imagePath = rtrim($this->getCacheImageBaseUrl($imagesUrl),'/');
        $imageFileName = $image->alias . '.' . $image->extension;
        $this->_clearImageFiles(DIR . $imagePath, $imageFileName);
    }

//===
    protected function _clearImageFiles($dir, $imageFileName)
    {
        $handle = opendir($dir);
        if (!$handle) return;
        while (false !== ($fname = readdir($handle))) {
              if (is_dir( $dir . '/' . $fname)) {
                 if (($fname != '.') && ($fname != '..')) {
                    $this->_clearImageFiles( $dir .'/' . $fname, $imageFileName);
                 }
              } else {
                 if($fname == $imageFileName) {
                    unlink( $dir .'/' . $fname);
                 }
              }
        }
        closedir($handle);
    }
}

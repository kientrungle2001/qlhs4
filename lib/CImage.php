<?php

	// includo la classe

require_once("thumbncrop.inc.php");
define('ROPTH', dirname(dirname(__FILE__)));
class CImage {
	public $image;
	public $file_name;
	public $gd_image;
	static $init_asido = false;
	public $thumbname;
	
	function __construct($file_name)
	{
		try
		{
			CImage::$init_asido = true;
			if(file_exists($file_name))
				$this->file_name = $file_name;
			else 
				$this->file_name = 'media/no_image.gif';
			
		}
		catch(Exception $e)
		{
			CLog('ERROR', $e->getMessage());
		}
	}
	function &thumb($width, $height,$thumb){
		$tb = new ThumbAndCrop();
		$tb->openImg(ROPTH.'/'.$this->file_name);
		$oldWidth = $tb->getWidth();
		$oldHeight = $tb->getHeight();
		
		$cropSize = $tb->getFitCropSize($width, $height);
		
		$newWidth = $cropSize['width'];
		$newHeight = $cropSize['height'];
		
		$tb->cropThumb($newWidth, $newHeight, ($oldWidth - $newWidth) / 2, ($oldHeight - $newHeight) / 2);
		if(1){
			$tb->setThumbAsOriginal();
			$tb->addWatermark(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logo.png');
		}
		
		$tb->setThumbAsOriginal();
		//$tb->resetOriginal();
		$tb->creaThumb($width, $height);
		//$this->thumbname = $thumb;
		
		$tb->saveThumb(ROPTH.'/'.$thumb);
		$tb->closeImg();
	}
	
	public function thumbImage($width,$height){
		$thumbname = $this->getThumbName($width,$height);
		//$thumbname = substr($this->file_name,0,-4) .'_thumb6_'.'x'.$width.'x'.$height.substr($this->file_name,-4);
		if(!file_exists($thumbname)) {
			$this->thumb($width, $height,$thumbname);
		}
		return $thumbname;
	}
	
	public function getThumbName($width,$height) {
		$s = explode('.', $this->file_name);
		$ext = array_pop($s);
		$pre = implode('.', $s);
		return $pre .'.thumb6_'.'x'.$width.'x'.$height.'.jpg';
	}
	
	public function createThumb($width,$height) {
		$thumbname = $this->getThumbName($width,$height);
		$this->thumb($width, $height,$thumbname);
		return $thumbname;
	}
	
	public function addWatermark() {
		$s = explode('.', $this->file_name);
		
		$ext = array_pop($s);
		$pre = implode('.', $s);
		$thumbname = $pre .'_watermark1_.jpg';
		if(!file_exists($thumbname)) {
			$this->watermark($thumbname);
		}
		return $thumbname;
	}
	
	public function watermark($thumbname) {
		$tb = new ThumbAndCrop();
		$tb->openImg($this->file_name);
		$tb->addWatermark(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logo.png');
		$tb->saveThumb($thumbname);
		$tb->closeImg();
	}
}
function CImage($file_name)
{
	return new CImage($file_name);
}
	
	
?>
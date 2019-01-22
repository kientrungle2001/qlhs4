<?php
class PzkFormFckEditor extends PzkObject {
	public $boundable = false;
	public $layout = 'fckEditor';
	public $scriptable = true;
	public $arrayParams = 'id,className,tagName,packageName,name,width,height,value';
	public $scriptTo = 'head';
	public static $scripted = false;
	
	public function init() {
		if(!self::$scripted) {
			if (@$this->scriptTo && $scriptToElement = pzk_store_element($this->scriptTo)) {
				$scriptToElement->append(pzk_parse('<html.js src="/3rdparty/jquery/fckeditor/fckeditor.js" />'));
				$scriptToElement->append(pzk_parse('<html.js src="/js/form/fckEditor.js" />'));
			}
			self::$scripted = true;
		}
	}
}
?>
<?php
class PzkFormUploadify extends PzkObject {
	public $scriptable = true;
	public $layout = 'uploadify';
	public static $scripted = false;
	public $scriptTo = 'head';
	public function init() {
		if(!self::$scripted) {
			if (@$this->scriptTo && $scriptToElement = pzk_store_element($this->scriptTo)) {
				$scriptToElement->append(pzk_parse('<html.css src="/3rdparty/jquery/uploadify2/uploadify.css" />'));
				$scriptToElement->append(pzk_parse('<html.js src="/3rdparty/jquery/uploadify2/swfobject.js" />'));
				$scriptToElement->append(pzk_parse('<html.js src="/3rdparty/jquery/uploadify2/jquery.uploadify.v2.1.4.min.js" />'));
				//$scriptToElement->append(pzk_parse('<html.js src="{rurl /js/form/uploadify.js}" />'));
			}
			self::$scripted = true;
		}
	}
}
?>
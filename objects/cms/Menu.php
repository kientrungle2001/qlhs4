<?php
class PzkCmsMenu extends PzkObject {
	public $layout = 'menu';
	public $type = 'superfish';
	public $scriptTo = 'head';
	public static $scripted = false;
	public $scriptable = true;
	public function init() {
		if($this->type == 'superfish') {
			if(!self::$scripted) {
				if (@$this->scriptTo && $scriptToElement = pzk_element($this->scriptTo)) {
					$scriptToElement->append(pzk_parse('<html.js src="/3rdparty/superfish/dist/js/hoverIntent.js" />'));
					$scriptToElement->append(pzk_parse('<html.js src="/3rdparty/superfish/dist/js/superfish.min.js" />'));
					$scriptToElement->append(pzk_parse('<html.css src="/3rdparty/superfish/dist/css/superfish.css" />'));
				}
				self::$scripted = true;
			}
		}
	}
}
?>
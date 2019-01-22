<?php
class PzkSlideshow extends PzkObject {
	public $boundable = false;
	public $layout = 'slideshow';
	public $xml = false;
	public $items = false;
	public $scriptable = true;
	public $type = false;
	public function init() {
		if($this->type == 'nivo') {
			if ($page = _page()) {
				$page->addCss('/jquery/nivo-slider/nivo-slider.css');
				$page->addCss('/jquery/nivo-slider/themes/default/default.css');
				$page->addJs('/jquery/nivo-slider/jquery.nivo.slider.pack.js');
			}
		}
	}
}
?>
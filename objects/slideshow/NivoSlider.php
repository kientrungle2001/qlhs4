<?php
class PzkNivoSlider extends PzkObject {
	public function init() {
		if ($page = _page()) {
			$page->addLink();
			$page->addScript();
		}
	}
}
?>
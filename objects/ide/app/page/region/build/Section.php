<?php
class PzkIdeAppPageRegionBuildSection extends PzkObject {
	public $layout = 'ide/app/page/region/build/section';
	public function init() {
		$this->body = pzk_parse('<form.fckEditor name="body" height="400px"/>');
		$this->append($this->body);

		$item = pzk_element('build')->getItem();
		$this->body->value = @$item['body'];
		
	}
}
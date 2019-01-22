<?php
class PzkIdeAppPageRegionBuildText extends PzkObject {
	public $layout = 'ide/app/page/region/build/text';
	public $code = false;
	public $style = false;
	public function init() {
		$this->code = pzk_parse('<form.fckEditor name="code" height="400px"/>');
		$this->style = pzk_parse('<form.textArea name="style" width="100%" height="400px"/>');
		$this->append($this->code);
		$this->append($this->style);
		$item = pzk_element('build')->getItem();
		$this->code->value = @$item['code'];
		$this->style->value = @$item['style'];
		
	}
}
<?php
class PzkEasyuiLayoutToolbarItem extends PzkObject {
	public $icon;
	public $action;
	public $layout = 'easyui/layout/toolbarItem';
	public function init() {
		$this->action = str_replace('$', 'pzk.elements.', $this->action);
	}
}
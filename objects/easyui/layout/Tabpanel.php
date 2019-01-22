<?php
pzk_loader()->importObject('easyui/layout/Panel');
class PzkEasyuiLayoutTabpanel extends PzkEasyuiLayoutPanel {
	public $layout = 'easyui/layout/tabpanel';
	public $closable = false;
	public $selected = false;
}
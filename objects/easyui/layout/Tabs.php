<?php
class PzkEasyuiLayoutTabs extends PzkObject {
	public $layout = 'easyui/layout/tabs';
	public $width = false;
	public $height = false;
	public $plain = false;
	public $fit = false;
	public $border = false;
	public $scrollIncrement = false;
	public $scrollDuration = false;
	public $tools = false;
	public $toolPosition = false;
	public $tabPosition = false;
	public $headerWidth = false;
	public $tabWidth = false;
	public $tabHeight = false;
	public $selected = false;
	public $showHeader = false;
	
	public $onLoad = false;
	public $onSelect = false;
	public $onUnselect = false;
	public $onBeforeClose = false;
	public $onClose = false;
	public $onAdd = false;
	public $onUpdate = false;
	public $onContextMenu = false;
}
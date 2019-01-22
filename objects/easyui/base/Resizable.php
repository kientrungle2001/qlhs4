<?php
class PzkEasyuiBaseResizable extends PzkObject {
	public $layout = 'easyui/base/resizable';
	public $disabled = false;
	public $handles = false;
	public $minWidth = false;
	public $minHeight = false;
	public $maxWidth = false;
	public $maxHeight = false;
	public $edge = false;
	
	public $onStartResize = false;
	public $onResize = false;
	public $onStopResize = false;
	
}
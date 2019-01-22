<?php
class PzkEasyuiBaseTooltip extends PzkObject {
	public $layout = 'easyui/base/tooltip';
	
	public $position = false;
	public $content = false;
	public $trackMouse = false;
	public $deltaX = false;
	public $deltaY = false;
	public $showEvent = false;
	public $hideEvent = false;
	public $showDelay = false;
	public $hideDelay = false;
	
	public $onShow = false;
	public $onHide = false;
	public $onUpdate = false;
	public $onPosition = false;
	public $onDestroy = false;
}
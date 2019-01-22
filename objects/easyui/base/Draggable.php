<?php
class PzkEasyuiBaseDraggable extends PzkObject {
	public $layout = 'easyui/base/draggable';
	// method
	public $proxy = false;
	// fields
	
	public $revert = false;
	public $cursor = false;
	public $deltaX = false;
	public $deltaY = false;
	public $handle = false;
	public $disabled = false;
	public $edge = false;
	public $axis = false;
	
	//events
	public $onBeforeDrag = false;
	public $onStartDrag = false;
	public $onDrag = false;
	public $onStopDrag = false;
}
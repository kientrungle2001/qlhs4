<?php
class PzkEasyuiBaseDroppable extends PzkObject {
	public $layout = 'easyui/base/droppable';
	
	public $accept = false;
	public $disabled = false;
	
	public $onDragEnter = false;
	public $onDragOver = false;
	public $onDragLeave = false;
	public $onDrop = false;
}
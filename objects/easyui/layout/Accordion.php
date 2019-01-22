<?php
class PzkEasyuiLayoutAccordion extends PzkObject {
	public $layout = 'easyui/layout/accordion';
	public $width = false;
	public $height = false;
	public $fit = false;
	public $border = false;
	public $animate = false;
	public $multiple = false;
	public $selected = false;
	
	public $onSelect = false;
	public $onUnselect = false;
	public $onAdd = false;
	public $onBeforeRemove = false;
	public $onRemove = false;
}
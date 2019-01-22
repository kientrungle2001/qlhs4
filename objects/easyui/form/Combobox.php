<?php
class PzkEasyuiFormCombobox extends PzkObject {
	public $layout = 'easyui/form/combobox';
	public $valueField = false;
	public $textField = false;
	public $groupField = false;
	public $groupFormatter = false;
	public $mode = false;
	public $url = false;
	public $method = false;
	public $data = false;
	public $filter = false;
	public $formatter = false;
	public $loader = false;
	public $loadFilter = false;
	
	public $onBeforeLoad = false;
	public $onLoadSuccess = false;
	public $onLoadError = false;
	public $onSelect = false;
	public $onUnselect = false;
	
}
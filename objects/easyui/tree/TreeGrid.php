<?php
class PzkEasyuiTreeTreeGrid extends PzkObject {
	public $layout = 'easyui/tree/treegrid';
	public $table = false;
	public $url = false;
	public $controller = '/Dtable';
	public $width = 'auto';
	public $height = 'auto';
	public $pagination = 'false';
	public $rownumbers = 'true';
	public $fitColumns = 'true';
	public $singleSelect = 'true';
	public $collapsible = 'true';
	public $method = 'post';
	public $scriptable = 'true';
	public $multiSort = 'true';
	public $resizeHandle = 'right';
	public $autoRowHeight = 'true';
	public $toolbar = false;
	public $striped = false;
	public $nowrap = 'true';
	public $idField = false;
	public $rootId = false;
	public $loadMsg = 'Processing, please wait...';
	
	public function init() {
		if(@$this->table) {
			$this->url = BASE_REQUEST . $this->controller . '/treejson/' . $this->table;
			if($this->rootId)
				$this->url .= '/' . $this->rootId;
		}
	}
}
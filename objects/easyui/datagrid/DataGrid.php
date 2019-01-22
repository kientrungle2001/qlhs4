<?php
class PzkEasyuiDataGridDataGrid extends PzkObject {
	public $layout = 'easyui/datagrid/datagrid';
	public $table = false;
	public $url = false;
	public $controller = '/Dtable';
	public $width = 'auto';
	public $height = 'auto';
	public $pagination = 'true';
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
	public $loadMsg = 'Processing, please wait...';
	public function init() {
		if(@$this->table) {
			$this->url = BASE_REQUEST . $this->controller . '/json?table=' . $this->table;
		}
		if(@$this->defaultFilters) {
			$filters = json_decode($this->defaultFilters, true);
			foreach($filters as $key => $value) {
				$this->url .= '&filters[' . $key . ']=' . $value;
			}
		}
	}
}
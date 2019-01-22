<?php
class PzkEasyuiBasePagination extends PzkObject {
	public $layout = 'easyui/base/pagination';
	
	public $total = false;
	public $pageSize = false;
	public $pageNumber = false;
	public $pageList = false;
	public $loading = false;
	public $buttons = false;
	public $links = false;
	public $showPageList = false;
	public $showRefresh = false;
	public $beforePageText = false;
	public $afterPageText = false;
	public $displayMsg = false;
	
	public $onSelectPage = false;
	public $onBeforeRefresh = false;
	public $onRefresh = false;
	public $onChangePageSize = false;
}
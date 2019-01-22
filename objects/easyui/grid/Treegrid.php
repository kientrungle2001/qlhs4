<?php
class PzkEasyuiGridTreegrid extends PzkObject {
	public $layout = 'easyui/grid/treegrid';
	public $idField = false;
	public $treeField = false;
	public $animate = false;
	public $loader = false;
	public $loadFilter = false;
	public $onClickRow = false;
	public $onDblClickRow = false;
	public $onClickCell = false;
	public $onDblClickCell = false;
	public $onBeforeLoad = false;
	public $onLoadSuccess = false;
	public $onLoadError = false;
	public $onBeforeExpand = false;
	public $onExpand = false;
	public $onBeforeCollapse = false;
	public $onCollapse = false;
	public $onContextMenu = false;
	public $onBeforeEdit = false;
	public $onAfterEdit = false;
	public $onCancelEdit = false;
}
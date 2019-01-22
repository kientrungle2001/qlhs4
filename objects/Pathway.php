<?php
class PzkPathway extends PzkObject {
	public $path = false;
	public $layout = 'pathway';
	public $model = 'Pathway';
	public function init() {
		$this->dirs = explode('/', $this->path);
		$dirs = $this->dirs;
		$this->paths = array();
		while(count($dirs)){
			$path = implode('/', $dirs);
			$this->paths[] = $path;
			array_pop($dirs);
		}
	}
	
	public function loadData() {
		$this->items = $this->model->getItems($this->paths);
	}
}
?>
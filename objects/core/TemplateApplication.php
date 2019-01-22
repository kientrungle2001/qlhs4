<?php
class PzkTemplateApplication extends PzkObject {
	public $name = false;
	public $libraries = array();
	public $dispatcher = 'ElementBased';

	public function init () {
	}

	public function display() {
		parent::display();
		require_once 'architectures/ApplicationDispatcher.php';
		require_once 'architectures/ApplicationDispatcher/'.$this->dispatcher.'.php';
		$dispatcher = 'PzkApplicationDispatcher' . $this->dispatcher;
		$dpInstance = new $dispatcher();
		$dpInstance->run($this);
	}

	public function getUri($path) {
		return 'applications/' . $this->name . '/' . $path;
	}

	public function getLayoutUri($path) {
		return $this->getUri('layout/' . $path);
	}

	public function getPageUri($page) {
		return $this->getUri('pages/' . $page);
	}

	public function getIncludeUri($include) {
		return $this->getPageUri('include/' . $include);
	}

	public function getComponentUri($comp, $mode) {
		return $this->getPageUri('components/' . $comp . '/' . $mode);
	}

	public function getTemplateUri($path) {
		if(@$this->template) {
			return $this->getUri('templates/' . $this->template . '/' . $path);
		}
		
		return $this->getUri('templates/' . $path);
		
	}

	public function getTemplateImageUri($path) {
		return $this->getTemplateUri('images/' . $path);
	}
}
?>
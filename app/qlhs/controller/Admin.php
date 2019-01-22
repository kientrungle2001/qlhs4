<?php
class PzkAdminController {
	
	public $app;
	
	public function indexAction() {
		
		$page = pzk_parse($this->getApp()->getPageUri('admin'));
		$page->display();
	}
	
	public function setApp($app) {
		$this->app = $app;
	}
	
	public function getApp() {
		return $this->app;
	}
}
?>
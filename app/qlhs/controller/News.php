<?php
class PzkNewsController {
	public $app;
	public function detailAction() {
		var_dump($_REQUEST);
	}
	
	public function setApp($app) {
		$this->app = $app;
	}
	
	public function getApp() {
		return $this->app;
	}
}
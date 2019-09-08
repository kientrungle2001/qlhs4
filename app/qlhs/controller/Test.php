<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkTestController extends PzkBaseController {
	public $grid = 'test';
	public function scheduleAction() {
		$this->viewGrid('test/schedule');
	}
	public function adviceAction() {
		$this->viewGrid('test/advice');
	}
	public function problemAction() {
		$this->viewGrid('test/problem');
	}
}
<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkSubjectController extends PzkBaseController {
	public $grid = 'subject';
	public function onlineAction() {
		$this->viewGrid('subject/online');
	}
	public function centerAction() {
		$this->viewGrid('subject/center');
	}
}
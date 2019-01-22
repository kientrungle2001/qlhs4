<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkProfileController extends PzkBaseController {
	public $grid = 'profile';
	public function permissionAction() {
		$this->viewGrid('permission');
	}
	public function grantAction() {
		$this->viewOperation('grant_permission');
	}
	public function typeAction() {
		$this->viewGrid('profile_type');
	}
}
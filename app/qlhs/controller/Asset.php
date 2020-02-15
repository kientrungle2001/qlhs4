<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkAssetController extends PzkBaseController {
	public $grid = 'asset';
	public function facilityAction() {
		// các phương tiện vật chất
		$this->viewGrid('asset/facility');
	}

	public function onlineAction() {
		// tài sản trực tuyến
		$this->viewGrid('asset/online');
	}

	public function documentAction() {
		// tài sản trực tuyến
		$this->viewGrid('asset/document');
	}

	public function scheduleAction() {
		// phân bổ tài sản
		$this->viewGrid('asset/schedule');
	}
}
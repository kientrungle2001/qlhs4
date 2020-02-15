<?php
class PzkPhanquyenController extends PzkController {
	public $masterPage = 'index';
	public $masterPosition = 'left';
	public function indexAction() {
		$this->viewGrid('phanquyen');
	}
}
<?php
class PzkThamsoController extends PzkController {
	public $masterPage = 'index';
	public $masterPosition = 'left';
	public function indexAction() {
		$this->viewGrid('thamso');
	}
}
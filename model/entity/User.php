<?php 
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityUserModel extends PzkEntityModel {
	public $table = 'user';
	public function getNumberOfNews() {
		$newss = _db()->select('id')->from('news')->where('userId='. $this->getId())->result();
		return count($newss);
	}
}
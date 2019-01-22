<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityAttributeEAVEntityModel extends PzkEntityModel {
	public $table = 'attribute_eav_entity';
	public $set = false;
	public function setAttributeSet($set) {
		$this->set = $set;
	}
}

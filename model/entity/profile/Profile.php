<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityProfileProfileModel extends PzkEntityModel {
	public $table = 'profile_profile';
	public function canDo($sourceTable, $action) {
		$type = _db()->useCB()->select('*')->from('attribute_catalog_type')
			->where(array('and', array('sourceTable', $sourceTable), array('code', $action)))
			->result_one('attribute.catalog.type');
		if(!$type) return false;
		$permission = _db()->useCB()->select('*')->from('profile_permission')
			->where(array('and', array('type', $this->get('type')), array('actionId', $type->get('id'))))
			->result_one();
		if(!$permission) return false;
		if($permission['status']) {
			return true;
		}
		return false;
	}
	public function hasPermission($setId, $action) {
	}
	public function getPermission($controller, $action) {
		$type = $this->get('type');
		if($type == 'Administrator') return true;
		$permission = _db()->useCB()->select('*')
			->from('profile_controller_permission')
			->where(array('and', 
				array('type', $type), 
				array('controller', $controller), 
				array('action', $action)))
			->result_one();
		if($permission && $permission['status']) {
			return true;
		}
		return false;
	}
}

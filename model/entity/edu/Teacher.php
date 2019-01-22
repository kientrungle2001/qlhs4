<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityEduTeacherModel extends PzkEntityModel {
	public $table = 'teacher';
	
	public function getClasses() {
		return _db()->select('*')->from('classes')
			->where('teacherId=' . $this->getId() . ' and status=1')
			->result('edu.class');
	}
	
	public function getLastName() {
		$names = explode(' ', $this->getName());
		return array_pop($names);
	}
	
}

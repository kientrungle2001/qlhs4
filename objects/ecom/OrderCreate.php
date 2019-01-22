<?php
class PzkEcomOrderCreate extends PzkObject {
	public $multiple = false;
	public function getClass() {
		if(!$this->multiple) {
			$class = _db()->select('*')->from('classes')->where(array('id' => $this->classId))->result();
			return $class[0];
		} else {
			$classes = array();
			$classIds = explode(',', $this->classIds);
			foreach($classIds as $classId) {
				$classes[] = _db()->select('*')->from('classes')->where(array('id' => $classId))->result_one();
			}
			return $classes;
			//$classes = _db()->select('*')->from('classes')->where('id IN (' . $this->classIds . ')')->result();
			//return $classes;
		}
	}
	
	public function getStudent() {
		$student = _db()->select('*')->from('student')->where('id='.$this->studentId)->result();
		return $student[0];
	}
	
	public function getPeriod() {
		$period = _db()->select('*')->from('payment_period')->where(array('id' => $this->periodId))->result();
		if(count($period))
		return $period[0];
		return null;
	}
}
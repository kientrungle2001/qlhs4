<?php
class PzkEduStudentList extends PzkObject{
	public $name = '';
	public $phone = '';
	public $classId = '';
	public $payment = '';
	public $payment_period = false;
	public function getSearchResult() {
		$conds = array();
		if($this->name) {
			$conds[] = array('student`.`name' => array('cp' => 'like', 'value' => $this->name));
		}
		if($this->phone) {
			$conds[] = array('student`.`phone' => array('cp' => 'like', 'value' => $this->phone));
		}
		if($this->classId) {
			$conds[] = array('class_student`.`classId' => $this->classId);
		}
		$payments = array();
		$query = _db()->select('student.*, `class_student`.classId as classId, group_concat(classes.name) as classNames, count(student_order.id) as total_order, student_order.payment_periodId')
		->from('`student` 
				left join `class_student` on student.id = class_student.studentId
				left join `student_order` on student.id = student_order.studentId and `student_order`.`classId` = `class_student`.`classId`
				left join `classes` on class_student.classId = classes.id')
		->groupBy('student.id');
		if(1 && $this->payment_period) {
			
			if($this->payment) {
				
				if(isset($this->payment[0])) {
					if(isset($this->payment[1])) {
						// do nothing
					} else {
						$query->having( "((payment_periodId={$this->payment_period} and (count(student_order.id)=0) or (payment_periodId is null)))");
					}
				} else {
					if(isset($this->payment[1])) {
						$conds[] = array('payment_periodId' => $this->payment_period);
						$conds[] = array('total_order' => array('cp' => '>', 'value' => '0'));
					} else {
					}
				}
			}
			
			
		}
		$rs = $query->where($conds)->result();
		return $rs;
	}
}
<?php
class PzkEduOrderstatTab extends PzkObject {
	public $classId;
	public $layout = 'edu/paymentstateTab2';
	public function getStudents() {
		$students = _db()->select('s.*, cs.endClassDate, cs.startClassDate')->from('`class_student` as cs 
				inner join `student` as s on cs.studentId=s.id')->where('classId='.$this->classId)->orderBy('s.name asc')->result();
		$results = array();
		foreach($students as $student) {
			$results[$student['id']] = $student;
		}
		return $results;
	}
	public function getClass($entity = 'edu.class') {
		if($entity === false || $entity === 'false') {
			$entity = false;
		}
		return _db()->useCB()->fromClasses()->whereId($this->getClassId())->result_one($entity);
	}
	
	public function getPaymentPeriods($classId = false) {
		$class = null;
		if($classId) {
			$classes = _db()->select('*')->from('classes')->where('id=' . $classId)->result();
			if(@$classes[0]) {
				$class = $classes[0];
			}
		}
		if(!$class)
			return _db()->select('*')->from('`payment_period`')->orderBy('startDate desc')->result();
		$query = _db()->select('*')->from('`payment_period`')->orderBy('startDate desc');
		return $query->result();
	}
	
	public function getStructureOrders() {
		$rs = array();
		$orders = $this->getOrders();
		foreach($orders as $order) {
			if(!isset($rs[$order['classId']][$order['studentId']][$order['payment_periodId']])) {
				$rs[$order['classId']][$order['studentId']][$order['payment_periodId']] = array();
			}
			if(!count($rs[$order['classId']][$order['studentId']][$order['payment_periodId']]))
				$rs[$order['classId']][$order['studentId']][$order['payment_periodId']][] = $order;
		}
		return $rs;
	}
	
	public function getOrders() {
		return _db()->select('student_order.*')->from('`student_order` inner join general_order on student_order.orderId=general_order.id inner join class_student on student_order.studentId = class_student.studentId')->where('class_student.classId=' . $this->classId . ' and general_order.status=\'\'')->result();
	}
	
	public function getStructureScheduleSummary() {
		$rs = array();
		$schedules = $this->getSchedules();
		$periods = $this->getPaymentPeriods(0);
		foreach($schedules as $schedule) {
			foreach($periods as $period) {
				if($schedule['studyDate'] >= $period['startDate'] and $schedule['studyDate'] < $period['endDate']) {
					if(!isset($rs[$schedule['classId']][$schedule['studentId']][$period['id']])) {
						$rs[$schedule['classId']][$schedule['studentId']][$period['id']] = array(
							'status' => array()
						);
					}
					$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status'][$schedule['status']] = 
						@$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status'][$schedule['status']] + 1;
					//$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status']['4'] = 
						//@$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status']['4'] + 1;
				}
			}
		}
		return $rs;
	}
	
	public function getSchedules() {
		return _db()->select('*')->from('`student_schedule` inner join class_student on student_schedule.studentId = class_student.studentId and student_schedule.classId = class_student.classId')->where('class_student.classId=' . $this->classId)->result();
	}
	
	public function getTotalScheduleSummary() {
		$rs = array();
		$periods = $this->getPaymentPeriods(0);
		$schedules = $this->getClassSchedules();
		foreach($periods as $period) {
			foreach($schedules as $schedule) {
				if($schedule['studyDate'] >= $period['startDate'] and $schedule['studyDate'] < $period['endDate']) {
					$rs[$schedule['classId']][$period['id']] = @$rs[$schedule['classId']][$period['id']] + 1;
				}
			}
		}
		return $rs;
	}
	
	public function getClassSchedules() {
		return _db()->select('*')->from('schedule')->where('classId='. $this->classId)->result();
	}
	
	public function getTotalTeacherScheduleSummary() {
		$rs = array();
		$periods = $this->getPaymentPeriods(0);
		$schedules = $this->getTeacherSchedules();
		foreach($periods as $period) {
			foreach($schedules as $schedule) {
				if($schedule['studyDate'] >= $period['startDate'] and $schedule['studyDate'] < $period['endDate']) {
					$rs[$schedule['classId']][$period['id']][$schedule['teacherId']] = @$rs[$schedule['classId']][$period['id']][$schedule['teacherId']] + 1;
				}
			}
		}
		return $rs;
	}
	
	public function getTeacherSchedules() {
		return _db()->select('*')->from('teacher_schedule')->result();
	}
}
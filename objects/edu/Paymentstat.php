<?php 
class PzkEduPaymentstat extends PzkObject {
	public $layout = 'edu/paymentstat';
	public function getClasses() {
		return _db()->select('c.id, c.*, s.name as subjectName, t.name as teacherName, 
					c.startDate as startDate, r.name as roomName')->from('`classes` as c 
					left join `subject` as s on c.subjectId = s.id 
					left join `teacher` as t on c.teacherId = t.id
					left join `room` as r on c.roomId = r.id')->orderBy('c.name asc')
			->where('c.status=1')
			->result();
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
	
	public function getStudents($classId) {
		return _db()->select('s.*')->from('`class_student` as cs 
				inner join `student` as s on cs.studentId=s.id')->where('classId='.$classId)->orderBy('s.name asc')->result();
	}
	
	public function getOrders() {
		return _db()->select('*')->from('student_order')->result();
	}
	
	public function getSchedules() {
		return _db()->select('*')->from('student_schedule')->result();
	}
	
	public function getTeacherSchedules() {
		return _db()->select('*')->from('teacher_schedule')->result();
	}
	
	public function getStructureOrders() {
		$rs = array();
		$orders = $this->getOrders();
		foreach($orders as $order) {
			if(!isset($rs[$order['classId']][$order['studentId']][$order['payment_periodId']])) {
				$rs[$order['classId']][$order['studentId']][$order['payment_periodId']] = array();
			}
			$rs[$order['classId']][$order['studentId']][$order['payment_periodId']][] = $order;
		}
		return $rs;
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
					$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status']['4'] = 
						@$rs[$schedule['classId']][$schedule['studentId']][$period['id']]['status']['4'] + 1;
				}
			}
		}
		return $rs;
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
		return _db()->select('*')->from('schedule')->result();
	}
	
	public function getTeachers() {
		$teachers = _db()->select('*')->from('teacher')->result();
		$results = array();
		foreach($teachers as $teacher) {
			$results[$teacher['id']] = $teacher;
		}
		return $results;
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
}
<?php
class PzkEduStudentDetail extends PzkObject{
	public $studentId = '';
	public function getDetail() {
		$student = _db()->select('student.*, class_student.classId as classId, group_concat(classes.name) as classNames')
			->from('`student` 
				left join `class_student` on student.id = class_student.studentId
				left join `classes` on class_student.classId = classes.id')->where('student.id='. $this->studentId)->result();
		if($student) {
			$student = $student[0];
			$classes = _db()->select('classes.*')
				->from('`class_student` inner join `classes` on `class_student`.classId = `classes`.id')
				->where('class_student.studentId='.$student['id'])->orderBy('classes.name asc')->result();
			$periods = _db()->select('*')->from('payment_period')->result();
			$schedules = $this->getStudentSchedules($student['id']);
			$classSchedules = $this->getClassSchedules();
			$orders = $this->getOrders($student['id']);
			foreach($classes as $key => &$class) {
				$new_periods = array();
				$last_period = false;
				foreach($periods as $p) {
					$period = array_merge(array(), $p);
					foreach($schedules as $schedule) {
						if($schedule['studyDate'] >= $period['startDate'] 
								and $schedule['studyDate'] < $period['endDate'] 
								and $schedule['classId'] == $class['id']) {
							$period[$schedule['status']] = @$period[$schedule['status']] + 1;
						}
					}
					foreach($classSchedules as $schedule) {
						if($schedule['studyDate'] >= $period['startDate'] 
								and $schedule['studyDate'] < $period['endDate'] and $schedule['classId'] == $class['id']) {
							$period['total'] = @$period['total'] + 1;
						}
					}
					$period['last_period'] = $last_period;
					$period['amount'] = $period['total'] * $class['amount'];
					$period['discount_amount'] = $last_period? @$last_period['2'] * $class['amount'] : 0;
					$period['next_discount_amount'] = @$period['2'] * $class['amount'];
					$period['need_amount'] = $period['amount'] - $period['discount_amount'];
					
					foreach($orders as $order) {
						if($order['classId'] == $class['id'] 
							&& $order['studentId'] == $student['id']
							&& $order['payment_periodId'] == $period['id']
							) {
								$period['orderId'] = $order['id'];
						}
					}
					
					$new_periods[] = $period;
					$last_period = $period;
				}
				
				$class['periods'] = $new_periods;
			}
			$student['classes'] = $classes;
			return $student;
		}
		return false;
	}
	
	public function getStudentSchedules($studentId) {
		return _db()->select('*')->from('student_schedule')->where(array('studentId' => $studentId))->result();
	}
	
	public function getClassSchedules() {
		return _db()->select('*')->from('schedule')->result();
	}
	
	public function getOrders($studentId) {
		return _db()->select('*')->from('student_order')->where(array('studentId' => $studentId))->result();
	}
}
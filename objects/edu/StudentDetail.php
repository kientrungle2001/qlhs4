<?php
class PzkEduStudentDetail extends PzkObject{
	public $studentId = '';
	public function getDetail() {
		$student = _db()->select('student.*, class_student.classId as classId, group_concat(classes.name) as classNames')
			->from('`student` 
				inner join `class_student` on student.id = class_student.studentId
				inner join `classes` on class_student.classId = classes.id')->where('student.id='. $this->studentId)->result();
		if($student) {
			$student = $student[0];
			$classes = _db()->select('classes.*, class_student.startClassDate, class_student.endClassDate')
				->from('`class_student` inner join `classes` on `class_student`.classId = `classes`.id')
				->where('class_student.studentId='.$student['id'])->orderBy('classes.name asc')->result();
			$periods = _db()->select('*')->from('payment_period')->orderBy('startDate asc')->result();
			$schedules = $this->getStudentSchedules($student['id']);
			$classSchedules = $this->getClassSchedules();
			$orders = $this->getOrders($student['id']);
			foreach($classes as $key => &$class) {
				$new_periods = array();
				$last_period = false;
				foreach($periods as $p) {
					$period = array_merge(array(), $p);
					$tuition_fee = _db()->useCB()->select('*')->from('tuition_fee')->where(array('and', array('classId', $class['id']), array('periodId', $period['id'])))->result_one();
					if($tuition_fee) {
						$oldClassAmount = $class['amount'];
						$class['amount'] = $tuition_fee['amount'];
					} else {
						if(isset($oldClassAmount))
							$class['amount'] = $oldClassAmount;
					}
					$offschedules = $this->getOffSchedules($p, $class['id']);
					foreach($schedules as $schedule) {
						if($schedule['studyDate'] >= $period['startDate'] 
								and $schedule['studyDate'] < $period['endDate'] 
								and $schedule['classId'] == $class['id']) {
							$continue = false;
							foreach($offschedules as $off) {
								if($off['offDate']==$schedule['studyDate']) {
									$continue = true;
									if($off['paymentType'] == 'immediate') {
										$period['reason'] = @$period['reason'] . '['.date('d/m', strtotime($off['offDate'])).']' . $off['reason'];
										$period['total'] = @$period['total'] - 1;
									} else if($off['paymentType'] == 'later'){
										$period['later_reason'] = @$period['later_reason'] . '['.date('d/m', strtotime($off['offDate'])).']' . $off['reason'];
										$period[2] = @$period[2] + 1;
									}
									break;
								}
							}
							if($continue) continue;
							if(($class['startDate'] == '0000-00-00' or $schedule['studyDate'] >= $class['startDate']) and 
									($class['endDate'] == '0000-00-00' or $schedule['studyDate'] < $class['endDate'])) {
								if(($class['startClassDate'] == '0000-00-00' or $schedule['studyDate'] >= $class['startClassDate']) and 
										($class['endClassDate'] == '0000-00-00' or $schedule['studyDate'] < $class['endClassDate'])) {
									
									if($schedule['status'] == 4 || $schedule['status'] == 5) {
										$period['total'] = @$period['total'] - 1;
									}
									$period[$schedule['status']] = @$period[$schedule['status']] + 1;
								}
							}
						}
					}
					
					foreach($classSchedules as $schedule) {
						if($schedule['studyDate'] >= $period['startDate'] 
								and $schedule['studyDate'] < $period['endDate'] and $schedule['classId'] == $class['id']) {
							if(($class['startDate'] == '0000-00-00' or $schedule['studyDate'] >= $class['startDate']) and 
									($class['endDate'] == '0000-00-00' or $schedule['studyDate'] < $class['endDate'])) {
								if(($class['startClassDate'] == '0000-00-00' or $schedule['studyDate'] >= $class['startClassDate']) and 
										($class['endClassDate'] == '0000-00-00' or $schedule['studyDate'] < $class['endClassDate'])) {
									if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $schedule['studyDate']) {
										if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $schedule['studyDate']) {
											$period['total'] = @$period['total'] + 1;
										}
									}
								}
							}
						}
					}
					$period['last_period'] = $last_period;
					$period['amount'] = @$period['total'] * $class['amount'];
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
				
				$class['periods'] = array_reverse( $new_periods );
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
		$query = _db()->select('*')->from('student_order')->where(array('studentId' => $studentId))->useCB()->where(array('status', ''));
		return $query->result();
	}
	
	public function getOffSchedules($period, $classId) {
		$conds = '(offDate >= \'' . $period['startDate'] . '\' and offDate < \'' . $period['endDate'] . '\')';
		$conds .= ' and (`type`=\'center\' or (`type`=\'class\' and classId='.$classId . '))';
		return _db()->select('*')->from('off_schedule')->where($conds)->result();
	}
	
	public function getStudyDates($classId) {
		return _db()->select('*')
			->from('`schedule`')->where('classId='.$classId)
			->orderBy('studyDate asc')->result();
	}
	public function getStatuses($classId, $studentId) {
		return _db()->select('*')->from('student_schedule')->where('classId='.$classId . ' and studentId=' . $studentId)->result();
	}
}
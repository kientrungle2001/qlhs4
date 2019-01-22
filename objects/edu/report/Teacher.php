<?php
class PzkEduReportTeacher extends PzkObject {
	public $layout = 'edu/report/teacher';
	public $teacherId;
	public $periodId;
	public $classId;
	
	public function getSummary() {
		$cond = "1";
		$cond1 = "1";
		$cond2 = "1";
		if(intval($this->teacherId)) {
			$teacherId = $this->teacherId;
			$cond1 = "($cond1 and classes.teacherId='$teacherId')";
			$cond2 = "($cond2 and classes.teacher2Id='$teacherId')";
		}
		if(intval($this->classId)) {
			$classId = $this->classId;
			$cond1 = "($cond1 and classes.id='$classId')";
			$cond2 = "($cond2 and classes.id='$classId')";
		}
		if(intval($this->subjectId)) {
			$subjectId = $this->subjectId;
			$cond1 = "($cond1 and classes.subjectId='$subjectId')";
			$cond2 = "($cond2 and classes.subjectId='$subjectId')";
		}
		if(intval($this->periodId)) {
			$periodId = $this->periodId;
			$period = _db()->select('*')->from('payment_period')->where('id=' . $periodId)->result_one();
			$startDate = $period['startDate'];
			$endDate = $period['endDate'];
			$cond = "($cond and student_schedule.studyDate >='$startDate' and student_schedule.studyDate < '$endDate')";
		}
		
		$query = "(select classes.teacherId,concat((MONTH(student_schedule.studyDate)+1) div 2,'-', YEAR(student_schedule.studyDate)) as studyMonth, 
		classes.`name` as className, classes.amount as classAmount, teacher.name as teacherName, teacher.salary as teacherSalary, 
		student_schedule.classId, student_schedule.`status`, count(student_schedule.id) as statusCount,
		classes.amount * count(student_schedule.id) as classTotal,
		classes.amount * count(student_schedule.id) * teacher.salary / 100 as teacherTotal,
		classes.amount * count(student_schedule.id) * (100-teacher.salary) / 100 as centerTotal,
		COUNT(DISTINCT student_schedule.studyDate) as countStudyDate, 
		COUNT(DISTINCT student_schedule.studentId) as countStudent
from student_schedule 
			inner join teacher_schedule on student_schedule.classId = teacher_schedule.classId and student_schedule.studyDate = teacher_schedule.studyDate
			inner join classes on student_schedule.classId = classes.id and teacher_schedule.teacherId = classes.teacherId 
			INNER JOIN teacher on classes.teacherId = teacher.id
where (student_schedule.`status`=1 or student_schedule.`status`=3) and $cond and $cond1
GROUP BY classes.teacherId, student_schedule.classId, studyMonth) UNION

(select classes.teacher2Id as teacherId,concat((MONTH(student_schedule.studyDate)+1) div 2,'-', YEAR(student_schedule.studyDate)) as studyMonth, 
		classes.`name` as className, classes.amount as classAmount, teacher.name as teacherName, teacher.salary as teacherSalary, 
		student_schedule.classId, student_schedule.`status`, count(student_schedule.id) as statusCount,
		classes.amount * count(student_schedule.id) as classTotal, 
		classes.amount * count(student_schedule.id) * teacher.salary / 100 as teacherTotal,
		classes.amount * count(student_schedule.id) * (100-teacher.salary) / 100 as centerTotal,
		COUNT(DISTINCT student_schedule.studyDate) as countStudyDate, 
		COUNT(DISTINCT student_schedule.studentId) as countStudent
from student_schedule 
			inner join teacher_schedule on student_schedule.classId = teacher_schedule.classId and student_schedule.studyDate = teacher_schedule.studyDate
			inner join classes on student_schedule.classId = classes.id and teacher_schedule.teacherId = classes.teacher2Id
			INNER JOIN teacher on classes.teacher2Id = teacher.id
where (student_schedule.`status`=1 or student_schedule.`status`=3) and $cond and $cond2
GROUP BY classes.teacher2Id, student_schedule.classId, studyMonth);";
		$rows = _db()->query($query);
		$rs = array();
		foreach($rows as $row) {
			$teacher = $row['teacherName'];
			$month = $row['studyMonth'];
			$class = $row['className'];
			$rs[$teacher][$month][$class] = $row;
		}
		return $rs;
	}
	
	public function getStudents($classId) {
		$students = _db()->select('s.*, cs.startClassDate, cs.endClassDate')->from('`class_student` as cs 
				inner join `student` as s on cs.studentId=s.id')
				->where('classId='.$classId)->orderBy('s.name asc')->result();
		$result = array();
		foreach($students as $student){
			$result[$student['id']] = $student;
		}
		return $result;
	}
	
	public function getSummaryAll() {
		$summaryAll = array();
		$teachers = _db()->useCB()->select('*')->from('teacher');
		if($this->teacherId) {
			$teachers->where(array('id', $this->teacherId));
		}
		$teachers = $teachers->result();
		foreach($teachers as $teacher) {
			$classes = _db()->useCB()->select('*')->from('classes')->where(array('status', 1));
			if($this->classId) $classes->where(array('id', $this->classId));
			$classes->where(array('or', array('teacherId', $teacher['id']), array('teacher2Id', $teacher['id'])));
			$classes = $classes->result();
			$summary = array();
			foreach($classes as $class) {
				// loc ra cac ky hoc cua lop
				$conds = array('and');
				if($class['startDate'] !== '0000-00-00') {
					$conds[] = array('or', array('gte', 'startDate', $class['startDate']), array('gt', 'endDate', $class['startDate']));
				}
				if($class['endDate'] !== '0000-00-00') {
					$conds[] = array('or', array('lte', 'startDate', $class['endDate']), array('lt', 'endDate', $class['endDate']));
				}
				$conds[] = array('status', '1');
				if($this->periodId) {
					$conds[] = array('id', $this->periodId);
				}
				$periods = _db()->useCB()->select('*')->from('payment_period')
					->where($conds)->orderBy('startDate asc')->result();
				$periodByIds = array();
				foreach($periods as $period) {
					$periodByIds[$period['id']] = $period;
				}
				// lay danh sach hoc sinh
				$students = $this->getStudents($class['id']);
				
				// lay lich hoc cua lop trong cac ky
				$scheduleConds = array('and');
				$scheduleConds[] = array('equal', 'classId', $class['id']);
				$scheduleConds[] = array('gte', 'studyDate', min_array($periods, 'startDate'));
				$scheduleConds[] = array('lt', 'studyDate', max_array($periods, 'endDate'));
				$schedules = _db()->useCB()->select('studyDate')->from('schedule')->where($scheduleConds)->orderBy('studyDate asc')->result();
				
				// chia lich hoc theo cac ky
				$periodSchedules = array();
				foreach($periods as $period) {
					$periodSchedules[$period['id']] = array();
				}
				foreach($schedules as $schedule) {
					foreach($periods as $period) {
						if($schedule['studyDate'] >= $period['startDate'] &&  $schedule['studyDate'] < $period['endDate']) {
							$periodSchedules[$period['id']][] = $schedule['studyDate'];
						}
					}
				}
				
				// duyet qua cac ky
					// duyet qua cac hoc sinh
						// dua ra cac buoi hoc cua hoc sinh
				$periodStudentSchedules = array();
				foreach($periods as $period) {
					$periodStudentSchedules[$period['id']] = array();
					foreach($students as $student) {
						$studentScheduleDateCount = 0;
						foreach($periodSchedules[$period['id']] as $studyDate) {
							if(($student['startClassDate']==='0000-00-00' or $studyDate >= $student['startClassDate'])
								and
								($student['endClassDate']==='0000-00-00' or $studyDate < $student['endClassDate'])) {
									if($studentScheduleDateCount == 0) {
										$periodStudentSchedules[$period['id']][$student['id']] = array();
									}
									$studentScheduleDateCount++;
									$periodStudentSchedules[$period['id']][$student['id']][$studyDate] = '0';
							}
						}
					}
				}
				
				// danh dau cac trang thai diem danh
				$studentScheduleConds = array('and');
				$studentScheduleConds[] = array('equal', 'classId', $class['id']);
				$studentScheduleConds[] = array('gte', 'studyDate', min_array($periods, 'startDate'));
				$studentScheduleConds[] = array('lt', 'studyDate', max_array($periods, 'endDate'));
				$studentSchedules = _db()->useCB()->select('studentId, studyDate, status')->from('student_schedule')->where($studentScheduleConds)->orderBy('studentId asc, studyDate asc')->result();
				
				foreach($studentSchedules as $studentSchedule){
					foreach($periods as $period) {
						if(isset($periodStudentSchedules[$period['id']][$studentSchedule['studentId']][$studentSchedule['studyDate']])) {
							$periodStudentSchedules[$period['id']][$studentSchedule['studentId']][$studentSchedule['studyDate']] = $studentSchedule['status'];
						}
					}
				}
				
				// lich nghi
				$offScheduleConds = array('and');
				$offScheduleConds[] = array(
					'or', 
					array(
						'and', 
						array('equal', 'classId', $class['id']),
						array('equal', 'type', 'class')
					),
					array('equal', 'type', 'center')
				);
				$offScheduleConds[] = array('gte', 'offDate', min_array($periods, 'startDate'));
				$offScheduleConds[] = array('lt', 'offDate', max_array($periods, 'endDate'));
				
				$scheduleDates = array();
				foreach($schedules as $schedule) {
					$scheduleDates[] = "'{$schedule['studyDate']}'";
				}
				if(count($scheduleDates))
					$offScheduleConds[] = array('in', 'offDate', $scheduleDates);
				$offSchedules = _db()->useCB()->select('*')->from('off_schedule')->where($offScheduleConds)->orderBy('offDate asc');
				$offSchedules = $offSchedules->result();
				
				// duyet qua cac lich nghi
				foreach($periods as $period) {
					foreach($offSchedules as $offSchedule) {
						if($offSchedule['offDate'] >= $period['startDate'] && $offSchedule['offDate'] < $period['endDate']) {
							foreach($students as $student) {
								if(isset($periodStudentSchedules[$period['id']][$student['id']][$offSchedule['offDate']])){
									$periodStudentSchedules[$period['id']][$student['id']][$offSchedule['offDate']] = ($offSchedule['paymentType'] == 'immediate') ? '4' : '2';
								}
							}
						}
					}
				}
				
				// bat dau tinh so buoi hoc
				$periodStudentStats = array(); 
				$lastPeriodId = null; // ki thanh toan truoc
				foreach($periodStudentSchedules as $periodId => $stds) {
					foreach($stds as $studentId => $scheduleDates) {
						$statuses = array_values($scheduleDates);
						for($i = 0; $i < 6; $i++) {
							$periodStudentStats[$periodId][$studentId][$i] = count_array($statuses, $i);
						}
						// so buoi nghi tru tien thang truoc
						if($lastPeriodId) {
							$periodStudentStats[$periodId][$studentId][6] = @$periodStudentStats[$lastPeriodId][$studentId][2];
						}
						$periodStudentStats[$periodId][$studentId]['total'] = count($statuses);
						$periodStudentStats[$periodId][$studentId]['sobuoihoc'] = $periodStudentStats[$periodId][$studentId]['total'] - @$periodStudentStats[$periodId][$studentId]['4'] - @$periodStudentStats[$periodId][$studentId]['6'];
						$periodStudentStats[$periodId][$studentId]['hocphi'] = $class['amount'] * $periodStudentStats[$periodId][$studentId]['sobuoihoc'];
					}
					$lastPeriodId = $periodId;
				}
				
				// xem danh sach hoa don
				$orderConds = array('and', 
					array('classId', $class['id']), 
					array('in','payment_periodId', array_keys($periodByIds)),
					array('in', 'studentId', array_keys($students))
				);
				$orders = _db()->useCB()->select('id, orderId, payment_periodId as periodId, studentId')->from('student_order')->where($orderConds)->result();
				
				// tinh xem hoc sinh da thanh toan hoc phi chua
				foreach($orders as $order) {
					$periodId = $order['periodId'];
					$studentId = $order['studentId'];
					if(isset($periodStudentStats[$periodId][$studentId])) {
						$periodStudentStats[$periodId][$studentId]['orderId'] = $order['orderId'];
					}
				}
				$summary['stat'][$class['id']] = $periodStudentStats;
				$summary['schedule'][$class['id']] = $periodStudentSchedules;
				$summary['periods'][$class['id']] = $periodByIds;
			}
			$summary['classes'] = $classes;	
			$summaryAll['summary'][$teacher['id']] = $summary;
		}
		$summaryAll['teachers'] = $teachers;
		return $summaryAll;
	}
}
?>
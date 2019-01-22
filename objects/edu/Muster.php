<?php 
class PzkEduMuster extends PzkObject {
	public $layout = 'edu/muster';
	public function getClasses() {
		return _db()->select('c.id, c.*, s.name as subjectName, t.name as teacherName, 
					c.startDate as startDate, r.name as roomName')->from('`classes` as c 
					left join `subject` as s on c.subjectId = s.id 
					left join `teacher` as t on c.teacherId = t.id
					left join `room` as r on c.roomId = r.id')->orderBy('c.name asc')
			->where('c.status=1')
			->result();
	}
	
	public function getStudyDates($classId) {
		return _db()->select('*')->from('`schedule`')->where('classId='.$classId)->orderBy('studyDate asc')->result();
	}
	
	public function getStudents($classId) {
		return _db()->select('s.*')->from('`class_student` as cs 
				inner join `student` as s on cs.studentId=s.id')->where('classId='.$classId)->orderBy('s.name asc')->result();
	}
	
	public function getTeachers() {
		$teachers = _db()->select('*')->from('teacher')->result();
		$results = array();
		foreach($teachers as $teacher) {
			$results[$teacher['id']] = $teacher;
		}
		return $results;
	}
	
	public function getStatuses() {
		return _db()->select('*')->from('student_schedule')->result();
	}
	
	public function getTeacherStatuses() {
		return _db()->select('*')->from('teacher_schedule')->result();
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
}
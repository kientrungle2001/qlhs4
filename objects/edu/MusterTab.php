<?php
class PzkEduMusterTab extends PzkObject {
	public $layout = 'edu/musterTab';
	public $classId;
	
	public function getClass() {
		return _db()->useCB()->select('*')->fromClasses()->whereId($this->getClassId())->result_one('edu.class');
	}
	
	public function getStudyDates() {
		return _db()->select('*')
			->from('`schedule`')->where('classId='.$this->classId)
			->orderBy('studyDate asc')->result();
	}
	
	public function getStudents($bool = false) {
		$students = _db()->select('s.*, cs.startClassDate, cs.endClassDate')->from('`class_student` as cs 
				inner join `student` as s on cs.studentId=s.id')
				->where('classId='.$this->classId)->orderBy('s.name asc')->result();
		if(!$bool)
			return $students;
		$result = array();
		foreach($students as $student){
			$result[$student['id']] = $student;
		}
		return $result;
	}
	
	public function getTeachers($teacherId1 = false, $teacherId2 = false) {
		$conds = '0';
		if($teacherId1) {
			$conds .= ' or id=' . $teacherId1;
		}
		if($teacherId2) {
			$conds .= ' or id=' . $teacherId2;
		}
		$teachers = _db()->select('*')->from('teacher')->where($conds)->result();
		$results = array();
		foreach($teachers as $teacher) {
			$results[$teacher['id']] = $teacher;
		}
		return $results;
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
	
	public function getStatuses() {
		return _db()->select('*')->from('student_schedule')->where('classId='.$this->classId)->result();
	}
	
	public function getTeacherStatuses() {
		return _db()->select('*')->from('teacher_schedule')->where('classId='. $this->classId)->result();
	}
}
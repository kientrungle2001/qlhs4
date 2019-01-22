<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkCourseController extends PzkBaseController {
	public $grid = 'classes';
	public function onlineAction() {
		$this->viewGrid('course/online');
	}
	public function centerAction() {
		$this->viewGrid('course/center');
	}
	public function studentAction() {
		$this->viewGrid('class_student');
	}
	
	public function scheduleAction() {
		$this->viewGrid('schedule');
	}
	
	public function layoutAction() {
		$this->viewGrid('layout');
	}
	
	public function xeplichAction() {
		// Tham khao database query trong /objects/core/database/ArrayCondition.php
		echo 'Schedule<br />';
		$query = _db()->useCB()->select('*')->from('student')->where(array('id', 3))->result();
		$query = _db()->useCB()->select('student.id, student.name, student_schedule.studyDate, student_schedule.status')
				->from('student')->join('student_schedule', 
						array('equal', array('column', 'student', 'id'), 
						array('column', 'student_schedule','studentId')) )
				->where(array('equal', array('column','student', 'id'), array('string', 3)))->result();
		var_dump($query);
	}
}
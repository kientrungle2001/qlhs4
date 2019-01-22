<?php
class PzkEduMusterclass extends PzkObject {
	public $layout = 'edu/musterclass';
	public function getStudents() {
		return _db()->select('class_student.id,student.*')->from('`class_student` inner join student on class_student.studentId = student.id')->where('classId=' . $_REQUEST['id'])->result();
	}
}
<?php
class PzkEduReportClass extends PzkObject {
	public $layout = 'edu/report/class';
	public function getSummary() {
		$cond = '1';
		if(intval($this->teacherId)) {
			$teacherId = $this->teacherId;
			$cond = "($cond and (classes.teacherId='$teacherId') or (classes.teacher2Id='$teacherId'))";
		}
		if(intval($this->classId)) {
			$classId = $this->classId;
			$cond = "($cond and classes.id='$classId')";
		}
		if(intval($this->subjectId)) {
			$subjectId = $this->subjectId;
			$cond = "($cond and classes.subjectId='$subjectId')";
		}
		if(intval($this->periodId)) {
			$periodId = $this->periodId;
			$period = _db()->select('*')->from('payment_period')->where('id=' . $periodId)->result_one();
			$startDate = $period['startDate'];
			$endDate = $period['endDate'];
			$cond = "($cond and student_schedule.studyDate >='$startDate' and student_schedule.studyDate < '$endDate')";
		}
		$query = "(select 
student.name as studentName, 
classes.name as className,
classes.amount as classAmount,
concat((MONTH(student_schedule.studyDate)+1) div 2,'-', YEAR(student_schedule.studyDate)) as studyMonth,  
student_schedule.`status`,
count(student_schedule.id) as statusCount
from student_schedule 
			INNER JOIN student on student_schedule.studentId = student.id
			inner join classes on student_schedule.classId = classes.id
where $cond
GROUP BY student_schedule.classId,studyMonth, student.id, student_schedule.`status`) ;";
		$rows = _db()->query($query);
		$rs = array();
		foreach($rows as $row) {
			$studyMonth = $row['studyMonth'];
			$class = $row['className'];
			$studentName = $row['studentName'];
			$status = $row['status'];
			$rs[$class][$studyMonth][$studentName][$status] = $row;
		}
		return $rs;
	}
}
?>
<?php
class PzkEduTeacherMusterstat extends PzkObject
{
	public $layout = 'edu/teacher/musterstat';
	public $teacherId = null;
	public $classId = null;
	public function getStats()
	{
		$stats = _db()->select('ts.teacherId, ts.classId, t.name as teacherName, c.name as className, count(*) as muster')->from('teacher_schedule as ts')
			->join("teacher as t", "ts.teacherId = t.id")
			->join("classes as c", "ts.classId = c.id")
			->groupBy('ts.teacherId, ts.classId');
		if ($this->getTeacherId()) {
			$stats->where(array('ts.teacherId', $this->getTeacherId()));
		}
		if ($this->getClassId()) {
			$stats->where(array('ts.classId', $this->getClassId()));
		}
		return $stats->result();
	}
}

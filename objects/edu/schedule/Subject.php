<?php
class PzkEduScheduleSubject extends PzkObject {
	public $layout = 'edu/schedule/subject';
	public function getSchedules() {
		return _db()->select('schedule.*, classes.name as className, 
					classes.roomId, classes.teacherId, classes.subjectId,
					room.name as roomName, teacher.name as teacherName, subject.name as subjectName')->fromSchedule()
			->joinClasses('schedule.classId=classes.id', 'left')
			->joinTeacher('classes.teacherId=teacher.id', 'left')
			->joinSubject('classes.subjectId=subject.id', 'left')
			->joinRoom('classes.roomId=room.id', 'left')
			->where('classes.subjectId=\''.$this->getSubjectId().'\' and concat(year(studyDate),\'-\', week(studyDate, 1))=\'' .$this->getWeek() . '\'')->orderBy('studyDate asc, studyTime asc, room.name asc, classes.name asc')->result();
	}
}
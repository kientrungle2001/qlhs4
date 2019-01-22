<?php
class PzkEduClassPaymentPeriod extends PzkObject {
	public $layout = 'edu/classPaymentPeriod';
	public function getClasses() {
		return _db()->select('c.id, c.*, s.name as subjectName, t.name as teacherName, 
					c.startDate as startDate, r.name as roomName')->from('`classes` as c 
					inner join `subject` as s on c.subjectId = s.id 
					inner join `teacher` as t on c.teacherId = t.id
					inner join `room` as r on c.roomId = r.id')->orderBy('c.name asc')
			->where('c.status=1 
				and (c.startDate = \'0000-00-00\' or c.startDate <= \''.date('Y-m-d', time()).'\')
				and (c.endDate = \'0000-00-00\' or c.endDate >= \''.date('Y-m-d', time()).'\')')
			->result();
	}
	public function getPaymentPeriods() {
		return _db()->select('*')->from('`payment_period`')->orderBy('startDate asc')->result();
	}
}
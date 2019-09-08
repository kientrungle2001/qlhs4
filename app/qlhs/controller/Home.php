<?php
// --IGNORE--
class PzkHomeController extends PzkController{
	
	public function indexAction() {
		$page = pzk_parse($this->getApp()->getPageUri('index'));
		$page->title = 'Trang chủ';
		$page->display();
	}
	
	public function smartyAction() {
		$smarty = $this->parse('smarty');
		$smarty->display();
	}
	
	public function studentAction() {
		set_time_limit(0);
		$query = "select student.*, group_concat(distinct(classes.name), ' ') as currentClassNames,
			group_concat(distinct(classes.id), ' ') as currentClassIds,
			group_concat(distinct(classes.teacherId), ' ') as teacherIds,
			group_concat('[', classes.name, ' ', case when student_order.payment_periodId = 0 then 'Cả khóa' else payment_period.name end, ']<br />' order by classes.name) as periodNames,
				group_concat('[', payment_period.id, ']') as periodIds from student 
					left join `class_student` on student.id = class_student.studentId
					left join `classes` on class_student.classId = classes.id
					left join `student_order` on student.id = student_order.studentId
						and classes.id = student_order.classId and student_order.status='' or student_order.status is null
					left join payment_period on student_order.payment_periodId = payment_period.id where 1 AND 1 AND 1 group by student.id order by student.id desc";
		$items = _db()->query($query);
		foreach($items as $item) {
			$student = _db()->getEntity('edu.student');
			$student->setData($item);
			$student->update(array('currentClassNames' => $item['currentClassNames'], 'currentClassIds' => $item['currentClassIds'], 'periodNames' => $item['periodNames'], 'periodIds' => $item['periodIds'],
			'teacherIds' => $item['teacherIds']));
			echo 'complete ' . $student->getId() . '<br />';
		}
		echo 'success';
	}

	public function updateStudentAction() {
		set_time_limit(0);
		$cond = '1';
		if(@$_REQUEST['id']) {
			$cond .= ' and student.id > ' . @$_REQUEST['id'];
		}
		$query = "select student.id, group_concat('[', class_student.className, ']') as currentClassNames,
			group_concat('[', class_student.classId, ']') as currentClassIds,
			group_concat('[', class_student.teacherId, ']') as teacherIds,
			group_concat('[', class_student.subjectName, ']') as subjectNames,
			group_concat('[', class_student.subjectId, ']') as subjectIds,
			group_concat('[', class_student.className, ' ', case when student_order.payment_periodId = 0 then 'Cả khóa' else payment_period.name end, ']<br />' order by class_student.className) as periodNames,
				group_concat('[', payment_period.id, ']') as periodIds from student 
					left join `class_student` on student.id = class_student.studentId
					left join `student_order` on student.id = student_order.studentId
						and class_student.classId = student_order.classId and student_order.status='' or student_order.status is null
					left join payment_period on student_order.payment_periodId = payment_period.id where $cond group by student.id order by student.id desc";
		
		$query = "update student as s, ($query) as i set s.currentClassNames = i.currentClassNames, s.currentClassIds = i.currentClassIds,s.periodNames = i.periodNames, s.periodIds = i.periodIds, s.subjectNames=i.subjectNames, s.subjectIds=i.subjectIds, s.teacherIds=i.teacherIds where s.id = i.id";
		if(@$_REQUEST['id']) {
			$query .= ' and s.id > ' . @$_REQUEST['id'];
		}
		echo $query;
		_db()->query($query);
		$updateClassStudentQuery = "update class_student, student set class_student.studentId = student.id where class_student.code = student.code and class_student.studentId=0 and class_student.code != '' and student.code != ''";
		_db()->query($updateClassStudentQuery);

		$updateStudentClassed = "update student, class_student set student.type=1 where class_student.code = student.code and class_student.code != '' and student.code != ''";
		_db()->query($updateStudentClassed);
		$resp = array(
			'success' => true,
			'errorMsg' => false,
			'msg' => 'Đã index xong' . (@$_REQUEST['id']? ' từ bản ghi ' . @$_REQUEST['id'] : '')
		);
		echo json_encode($resp);
	}

	public function indexClassesAction() {
		set_time_limit(0);
		// subject
		$query = "update classes set subjectName='' where subjectId=0";
		_db()->query($query);
		$query = "update classes as c, subject as s set c.subjectName = s.name where c.subjectId = s.id";
		_db()->query($query);

		// teacher
		$query = "update classes set teacherName='' where teacherId=0";
		_db()->query($query);
		$query = "update classes as c, teacher as t set c.teacherName = t.name where c.teacherId = t.id";
		_db()->query($query);

		$query = "update classes set teacher2Name='' where teacher2Id=0";
		_db()->query($query);
		$query = "update classes as c, teacher as t set c.teacher2Name = t.name where c.teacher2Id = t.id";
		_db()->query($query);

		// room
		$query = "update classes set roomName='' where roomId=0";
		_db()->query($query);
		$query = "update classes as c, room as r set c.roomName = r.name where c.roomId = r.id";
		_db()->query($query);

		/////////// Update class_student /////////////
		// studentName
		$query = "update class_student set studentName='' where studentId=0";
		_db()->query($query);
		$query = "update class_student as cs, student as s set cs.studentName=s.name where cs.studentId=s.id";
		_db()->query($query);
		// className, subjectName, teacherName, teacher2Name
		$query = "update class_student set className='', subjectName='', subjectId=0, teacherName='', teacherId=0, teacher2Name='', teacher2Id=0, roomName='', roomId=0 where classId=0";
		_db()->query($query);
		$query = "update class_student as cs, classes as c set cs.className=c.name, cs.subjectName=c.subjectName, cs.subjectId=c.subjectId, cs.teacherName=c.teacherName, cs.teacherId=c.teacherId, cs.teacher2Name=c.teacher2Name, cs.teacher2Id=c.teacher2Id, cs.roomName=c.roomName, cs.roomId=c.roomId where cs.classId=c.id";
		_db()->query($query);
		// echo 'success';
	}

	public function indexStudentAction() {
		set_time_limit(0);
		$this->indexClassesAction();
		$cond = '1';
		if(@$_REQUEST['id']) {
			$cond .= ' and student.id > ' . @$_REQUEST['id'];
		}
		$query = "select student.id, group_concat('[', class_student.className, ']') as currentClassNames,
			group_concat('[', class_student.classId, ']') as currentClassIds,
			group_concat('[', class_student.teacherId, ']') as teacherIds,
			group_concat('[', class_student.subjectName, ']') as subjectNames,
			group_concat('[', class_student.subjectId, ']') as subjectIds from student 
					left join `class_student` on student.id = class_student.studentId
			where $cond group by student.id order by student.id desc";
		
		$query = "update student as s join ($query) as i on s.id = i.id set 
				s.currentClassNames = i.currentClassNames, 
				s.currentClassIds = i.currentClassIds, 
				s.subjectNames=i.subjectNames, 
				s.subjectIds=i.subjectIds, 
				s.teacherIds=i.teacherIds";
		if(@$_REQUEST['id']) {
			$query .= ' where s.id > ' . @$_REQUEST['id'];
		}
		_db()->query($query);
		$updateClassStudentQuery = "update class_student, student set class_student.studentId = student.id where class_student.code = student.code and class_student.studentId=0 and class_student.code != '' and student.code != ''";
		_db()->query($updateClassStudentQuery);

		$updateStudentClassed = "update student, class_student set student.type=1 where class_student.code = student.code and class_student.code != '' and student.code != ''";
		_db()->query($updateStudentClassed);
		$resp = array(
			'success' => true,
			'errorMsg' => false,
			'msg' => 'Đã index xong' . (@$_REQUEST['id']? ' từ bản ghi ' . @$_REQUEST['id'] : '')
		);
		echo json_encode($resp);
	}
	
	public function testAction() {
		$classStudents = _db()
				->selectNone()->selectClassId()
				->selectStudentId()->selectStatus()
				->selectStudyDate()
				->fromStudent_schedule()->result();
		$arr = pzk_array();
		$arr->setData($classStudents);
		//$rs = $arr->groupBy(array('classId', 'studentId', 'status'));
		//var_dump($rs[8][4]);
		$arr->sortBy(array(array('classId', 'asc'), array('studentId', 'asc'), array('studyDate', 'asc'), array('status', 'asc')));
		//var_dump($arr->getData());
		echo 1;
	}
}

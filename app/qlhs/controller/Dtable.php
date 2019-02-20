<?php
require_once 'core/controller/Table.php';
class PzkDtableController extends PzkTableController {
	public $tables = array(
		'class_student' => array(
			'table' 
				=> '`class_student` as c 
					inner join `student` as s on c.studentId = s.id 
					inner join `classes` as cl on c.classId = cl.id',
			
			'fields' 
				=> 'c.id, c.*, s.name as studentName, s.phone as phone, cl.name as className, 
					cl.startDate as startDate'
		),
		'class_teacher' => array(
			'table' 
				=> '`class_teacher` as c 
					left join `teacher` as t on c.teacherId = t.id 
					left join `classes` as cl on c.classId = cl.id',
			
			'fields' 
				=> 'c.id, c.*, t.name as teacherName, t.phone as phone, cl.name as className, 
					cl.startDate as startDate'
		),
		'classes' => array(
			'table' 
				=> '`classes` as c 
					left join `subject` as s on c.subjectId = s.id 
					left join `teacher` as t on c.teacherId = t.id
					left join `teacher` as t2 on c.teacher2Id = t2.id
					left join `room` as r on c.roomId = r.id',
			'fields' 
				=> 'c.id, c.*, s.name as subjectName, t.name as teacherName, t2.name as teacher2Name, 
					c.startDate as startDate, r.name as roomName'
		),
		'student' => array(
			'table' => 'student',
			'orderBy' => 'id desc'
		),
		'teacher' => array(
			'table' => '`teacher` as t
				left join `subject` as s on t.subjectId = s.id',
			'fields' => 't.*, s.name as subjectName'
		),
		'teaching' => array(
			'table' => '`teaching` as t 
					inner join teacher as tc on t.teacherId = tc.id
					inner join subject as s on t.subjectId = s.id',
			'fields' => 't.id,t.*, tc.name as teacherName, s.name as subjectName, t.level'
		),
		'schedule' => array(
			'table' => '`schedule` as s 
					inner join classes as c on s.classId = c.id',
			'fields' => 's.id,s.*, c.name as className'
		),
		'off_schedule' => array(
			'table' => '`off_schedule` as s 
					left join classes as c on s.classId = c.id',
			'fields' => 's.id,s.*, c.name as className'
		),
		'payment_period' => array(
			'table' => '`payment_period` as p 
					left join classes as c on p.classId = c.id',
			'fields' => 'p.id,p.*, c.name as className'
		),
		'student_order' => array(
			'table' => '`student_order` as o
						left join `payment_period` as p on o.payment_periodId = p.id
						left join `student` as s on o.studentId = s.id 
						left join `classes` as c on o.classId = c.id',
			'fields' => 'o.id,o.*, c.name as className, s.name as studentName, p.name as periodName'
		),
		'level' => array(
			'table' => 'classes',
			'fields' => 'distinct(level) as id, level as name',
			'orderBy' => 'level asc'
		),
		'teacher_class' => array(
			'table' => 'teacher',
			'fields' => 'id, name',
			'orderBy' => 'id asc'
		),
		'general_order' => array(
			
		),
		'tuition_fee' => array(
			'table' => '`tuition_fee` as t 
				join `classes` as c on t.classId = c.id
				join `payment_period` as p on t.periodId = p.id',
			'fields' => 't.*, c.name as className, p.name as periodName'
		),
		'test' => [
			'table' => '`test` left join `subject` on `test`.subjectId=`subject`.id',
			'fields' => 'test.*, subject.name as subjectName'
		],
		'test_class' => [
			'table' => '`test_class` 
				left join `test` on `test_class`.testId=`test`.id
				left join `subject` on `test`.subjectId = `subject`.id
				left join `classes` on `test_class`.classId = `classes`.id',
			'fields' => 'test_class.*, test.name as testName, classes.name as className, subject.name as subjectName'
		],
		'test_student_mark' => [
			'table' => '`test_student_mark` as m
				left join `student` as st on `m`.studentId=`st`.id 
				left join `test` as t on `m`.testId=`t`.id
				left join `classes` as c on `m`.classId = `c`.id
				left join `subject` as s on `c`.subjectId = `s`.id',
			'fields' => 'm.*, st.name as studentName, t.name as testName, c.name as className, s.name as subjectName'
		],
		'advice' => [
			'table' => '`advice` as ad 
				left join `subject` as s on `ad`.subjectId=`s`.id
				left join `classes` as c on `ad`.classId = `c`.id
				left join `teacher` as t on `ad`.adviceId=`t`.id
				left join `student` as st on `ad`.studentId=`st`.id',
			'fields' => 'ad.*, s.name as subjectName, c.name as className, t.name as adviceName, st.name as studentName, st.phone'
		],
		'student_schedule' => [
			'table' => '`student_schedule` as ss
				left join `student` as s on ss.studentId = s.id
				left join `classes` as c on ss.classId = c.id',
			'fields' => 'ss.*, s.name as studentName, s.phone, c.name as className'
		],
		'teacher_schedule' => [
			'table' => '`teacher_schedule` as ts
				left join `teacher` as t on ts.teacherId = t.id
				left join `classes` as c on ts.classId = c.id',
			'fields' => 'ts.*, t.name as teacherName, t.phone, c.name as className'
		],
		'test_schedule' => [
			'table' => 'test_schedule as ts
					left join `classes` as c on ts.classId = c.id
					left join `student` as s on ts.studentId = s.id
					left join `subject` as sb on c.subjectId = sb.id
					left join `teacher` as t on ts.adviceId = t.id',
			'fields' => 'ts.*, c.name as className, c.subjectId, c.level, c.teacherId, s.name as studentName, s.phone as phone, sb.name as subjectName, t.name as adviceName'
		],
		'employee_absent' => [
			'table' => 'employee_absent as ea 
					left join employee as e on ea.employeeId = e.id',
			'fields' => 'ea.*, e.name as employeeName, e.code as employeeCode'
		],
		'asset_schedule' => array(
			'table'	=> 'asset_schedule as ah
					left join asset as a on ah.assetId = a.id
					left join subject as s on a.subjectId = s.id
					left join teacher as t on ah.teacherId = t.id
					left join employee as e on ah.employeeId = e.id',
			'fields' => 'ah.*, a.name, a.price, t.name as teacherName, e.name as employeeName, s.name as softwareName'
		)
	);
	
	public $inserts = array(
		'student' => array('name', 'phone', 'school', 'birthDate', 'address', 'parentName', 
		'startStudyDate', 'endStudyDate', 'note', 'color', 'fontStyle', 'assignId', 'online', 'classed', 'type', 'status', 'rating', 'code'),
		'classes' => array('name', 'startDate', 'endDate', 'roomId', 'subjectId', 'teacherId', 'teacher2Id', 'level', 'status', 'amount', 'online', 'code', 'feeType', 'classed'),
		'class_student' => array('classId', 'studentId', 'startClassDate', 'endClassDate', 'note'),
		'class_teacher' => array('classId', 'teacherId',  'note', 'status', 'role'),
		'room' => array('name', 'size', 'status', 'note'),
		'subject' => array('name', 'online', 'startDate', 'status', 'code'),
		'teacher' => array('name', 'phone', 'address', 'school', 'salary', 'password', 'subjectId', 'code'),
		'employee' => array('name', 'phone', 'address', 'code', 'startDate', 'endDate', 'departmentId', 'status'),
		'employee_absent' => array('employeeId', 'startDate', 'endDate', 'total', 'reason'),
		'partner' => array('name', 'phone', 'address', 'code', 'startDate', 'endDate', 'note', 'status'),
		'teaching' => array('subjectId', 'teacherId', 'level'),
		'schedule' => array('classId', 'studyDate', 'studyTime', 'status'),
		'off_schedule' => array('classId', 'offDate', 'type', 'reason', 'paymentType'),
		'payment_period' => array('classId', 'name', 'startDate', 'endDate', 'status', 'code'),
		'student_schedule' => array('classId', 'studentId', 'studyDate', 'status'),
		'teacher_schedule' => array('classId', 'teacherId', 'studyDate', 'status'),
		'student_order' => array('classId', 'studentId', 'payment_periodId', 'amount'),
		'profile_controller_permission' => array('type', 'controller', 'action', 'status'),
		'profile_profile' => array('username', 'password', 'type', 'fullName'),
		'profile_type' => array('name'),
		'class_student_period_mark' => array('classId', 'studentId', 'periodId', 'marks', 'note'),
		'tuition_fee' => array('classId', 'periodId',  'amount', 'status'),
		'test' => array('name', 'subjectId', 'level', 'status', 'code'),
		'test_class' => array('classId', 'testId', 'status', 'startDate', 'endDate'),
		'test_schedule' => array('classId', 'studentId', 'adviceId', 'status', 'testDate', 'testTime', 'note', 'title', 'mark', 'rating', 'type', 'adviceType'),
		'advice' => array('classId', 'subjectId', 'status', 'studentId', 'title', 'content', 'type', 'time', 'adviceId'),
		'test_student_mark' => array('testId', 'classId', 'mark', 'studentId', 'status'),
		'asset' => array('name', 'roomId', 'teacherId', 'storeId', 'quantity', 'status', 'price', 'subjectId', 'online', 'note', 'startDate', 'endDate', 'employeeId'),
		'asset_schedule' => array('assetId', 'roomId', 'teacherId', 'employeeId', 'quantity', 'status', 'startStatus', 'startDate', 'endDate'),
		'department' => array('name', 'status'),
		'plan' => array('name', 'code', 'startDate', 'endDate', 'goal', 'result', 'progress', 'subjectId', 'note', 'status'),
		'task' => array('name', 'code', 'startDate', 'endDate', 'goal', 'result', 'progress', 'subjectId', 'note', 'status', 'planId', 'departmentId', 'employeeId', 'teacherId'),
		'center' => array('name', 'code', 'address', 'status'),
		'problem' => array('name', 'content', 'studentId', 'employeeId', 'teacherId', 'subjectId', 'classId'),
		'location' => array('name', 'type', 'parentId'),
		'category' => array('name', 'parentId')
	);
	
	public $filters = array(
		'advice' => array(
			'none' => 0
		),
		'student' => array(
			'none' => 0
		),
		'general_order' => array(
			'none' => 0
		),
		'classes' => array(
			'none' => 0
		),
		'teacher' => array(
			'none' => 0
		),
		'employee' => array(
			'none' => 0
		),
		'partner' => array(
			'none' => 0
		),
		'teacher_class' => array(
			'none' => 0
		),
		'tuition_fee' => array(
			'none' => 0
		),
		'student_order' => array(
			'none' => 0
		),
		'class_student' => array(
			'none' => 0
		),
		'test_class' => array(
			'none' => 0
		),
		'test_student_mark' => array(
			'none' => 0
		),
		'subject' => array(
			'none' => 0
		),
		'schedule' => array(
			'none' => 0
		),
		'test_schedule' => array(
			'none' => 0
		),
		'advice_filter' => array(
			'where' => array(
				'classId' => array('equal', array('column', 'ad', 'classId'), '?'),
				'studentId' => array('equal', array('column', 'ad', 'studentId'), '?'),
				'adviceId' => array('equal', array('column', 'ad', 'adviceId'), '?'),
			)
		),
		'class_student_filter' => array(
			'where' => array(
				'studentName' => array('like', array('column', 's', 'name'), '%?%'),
				'classId' => array('equal', array('column', 'c', 'classId'), '?'),
				'studentId' => array('equal', array('column', 'c', 'studentId'), '?'),
			)
		),
		'teacher_class_filter' => array(
			'where' => array(
				'subjectId' => array('sql', 'id in (select teacherId as id from classes where subjectId=?) or id in (select teacher2Id as id from classes where subjectId=?)'),
				'level' => array('sql', 'id in (select teacherId as id from classes where level=?) or id in (select teacher2Id as id from classes where level=?)')
			)
		),
		'classes_filter' => array(
			'where' => array(
				'keyword' => array('sql', "(c.name like '%?%' or c.code like '%?%' or s.name like '%?%' or t.name like '%?%' or r.name like '%?%'  or t.code like '%?%')"),
				'status' => array('equal', array('column', 'c', 'status'), '?'),
				'subjectId' => array('equal', array('column', 'c', 'subjectId'), '?'),
				'teacherId' => array('equal', array('column', 'c', 'teacherId'), '?'),
				'roomId' => array('equal', array('column', 'c', 'roomId'), '?'),
				'level' => array('equal', array('column', 'c', 'level'), '?'),
				'online' => array('equal', array('column', 'c', 'online'), '?'),
				'classed' => array('equal', array('column', 'c', 'classed'), '?'),
			)
		),
		'teacher_filter' => array(
			'where' => array(
				'keyword' => array('sql', "(t.name like '%?%' or t.code like '%?%')"),
			)
		),
		'employee_filter' => array(
			'where' => array(
				'keyword' => array('sql', "(name like '%?%' or code like '%?%' or phone like '%?%')"),
			)
		),
		'partner_filter' => array(
			'where' => array(
				'keyword' => array('sql', "(name like '%?%' or code like '%?%' or phone like '%?%')"),
			)
		),
		'student_filter' => array(
			'where' => array(
				'keyword' => array('sql', "(name like '%?%' or phone like '%?%' or code like '%?%' or currentClassNames like '%?%' or periodNames like '%?%' or assignName like '%?%' or startStudyDate like '%?%' or subjectNames like '%?%')"),
				'name' => array('like', array('column', 'student', 'name'), '%?%'),
				'phone' => array('like', array('column', 'student', 'phone'), '%?%'),
				'classIds' => array('like', array('column', 'currentClassIds'), '%[?]%'),
				'subjectIds' => array('like', array('column', 'subjectIds'), '%[?]%'),
				'teacherIds' => array('like', array('column', 'teacherIds'), '%[?]%'),
				'periodId' =>  array('like', array('column', 'periodIds'), '%?%'),
				'notlikeperiodId' => array('sql', "periodIds not like '%?%'"),
				'color' => array('equal', array('column', 'color'), '?'),
				'fontStyle' => array('equal', array('column', 'fontStyle'), '?'),
				'assignId' => array('equal', array('column', 'assignId'), '?'),
				'online' => array('equal', array('column', 'online'), '?'),
				'type' => array('equal', array('column', 'type'), '?'),
				'status' => array('equal', array('column', 'status'), '?'),
				'classed' => array('equal', array('column', 'classed'), '?'),
				'rating' => array('equal', array('column', 'rating'), '?'),
			)
		),
		'general_order_filter' => array(
			'where' => array(
				'name' => array('like', array('column', 'name'), '%?%'),
				'phone' => array('like', array('column', 'phone'), '%?%')
			)
		),
		'test_class_filter' => array(
			'where' => array(
				'classId' => array('equal', array('column', 'test_class', 'classId'), '?'),
				'testId' => array('equal', array('column', 'test_class', 'testId'), '?'),
				'subjectId' => array('equal', array('column', 'test', 'subjectId'), '?'),
				'teacherId' => array('equal', array('column', 'classes', 'teacherId'), '?'),
			)
		),
		'test_student_mark_filter' => array(
			'where' => array(
				'studentId' => array('equal', array('column', 'm', 'studentId'), '?'),
				'testId' => array('equal', array('column', 'm', 'testId'), '?'),
				'classId' => array('equal', array('column', 'm', 'classId'), '?'),
				'teacherId' => array('equal', array('column', 'c', 'teacherId'), '?'),
				'subjectId' => array('equal', array('column', 't', 'subjectId'), '?'),
			)
		),
		'subject_filter' => array(
			'where' => array(
				'online' => array('equal', array('column', 'online'), '?'),
			)
		),
		'student_order_filter' => array(
			'where' => array(
				'studentId' => array('equal', array('column', 'studentId'), '?'),
				'classId' => array('equal', array('column', 'o', 'classId'), '?'),
				'periodId' => array('equal', array('column', 'o', 'payment_periodId'), '?'),
				'subjectId' => array('equal', array('column', 'c', 'subjectId'), '?'),
				'teacherId' => array('equal', array('column', 'c', 'teacherId'), '?'),
			)
		),
		'schedule_filter' => array(
			'where' => array(
				'studentId' => array('sql', '`c`.id in (select classId from `class_student` where studentId=?)'),
				'teacherId' => array('sql', '`c`.id in (select classId from `class_student` inner join classes on class_student.classId=classes.id where classes.teacherId=?)'),
				'roomId' => array('sql', '`c`.id in (select classId from `class_student` inner join classes on class_student.classId=classes.id where classes.roomId=?)'),
				'classId' => array('equal', array('column', 'classId'), '?'),
			)
			),
			'test_schedule_filter' => array(
				'where' => array(
					'classId' => array('equal', array('column', 'ts', 'classId'), '?'),
					'studentId' => array('equal', array('column', 'ts', 'studentId'), '?'),
					'type' => array('equal', array('column', 'ts', 'type'), '?'),
				)
			)
	);
	
	public $constraints = array(
		'class_student' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId', 'studentId'), 'message' => 'Bản ghi đã tồn tại' )),
		'student' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('name', 'phone', 'code'), 'message' => 'Bản ghi đã tồn tại' )),
		'student_schedule' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId', 'studentId', 'studyDate'), 'message' => 'Bản ghi đã tồn tại' )),
		'teacher_schedule' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId',  'studyDate'), 'message' => 'Bản ghi đã tồn tại' )),
		'profile_controller_permission' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('type',  'controller', 'action'), 'message' => 'Bản ghi đã tồn tại' )),
		'class_student_period_mark' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId',  'studentId', 'periodId'), 'message' => 'Bản ghi đã tồn tại' ))
	);
	
	public $deletes = array(
		'general_order' => array('student_order' => 'orderId'),
		'billing_order' => array('billing_detail_order' => 'orderId'),
		'student' => array(
			'class_student' => 'studentId',
			'general_order' => 'studentId',
			'student_order' =>	'studentId',
			'class_student_period_mark'	=> 'studentId',
			'student_schedule' =>	'studentId',
			'test_schedule' =>	'studentId',
			'test_student_mark'	=>	'studentId'
		)
	);
	public $statusDeletes = array('general_order' => true);
	public $exports = array(
		'student' => array(
			'childTables' => array(
				array(
					'table'	=> 'class_student',
					'referenceField' => 'studentId'
				),
				array(
					'table'	=>	'student_schedule',
					'referenceField'	=>	'studentId'
				)
			)
		)
	);
	
	public $onEdit = array(
	    'student' => 'onUpdateStudent'
	);

	public function onUpdateStudent($table, $data, $id) {
	    $data['id'] = $id;
	    file_put_contents(BASE_DIR . '/cache/'.$table.'.txt', json_encode($data), FILE_APPEND);
	}
	
	/**
	 * Thêm lịch học mới
	 */
	public function addscheduleAction() {
		$startTime = $this->_getTime($_REQUEST['startDate']);
		$endTime = $this->_getTime($_REQUEST['endDate']);
		$datas = array();
		for($time = $startTime; $time <= $endTime; $time += 24 * 3600) {
			if(date('w', $time) == $_REQUEST['weekday']) {
				$data = array(
					'classId' => $_REQUEST['classId'],
					'studyTime' => $_REQUEST['studyTime'],
					'studyDate' => date('Y-m-d', $time),
					'status' => '1'
				);
				$datas[] = $data;
			}
		}
		$fields = array('classId', 'studyTime', 'studyDate', 'status');
		_db()->insert('schedule')
				->fields(implode(',', $fields))
				->values($datas)->result();
		echo json_encode(array(
			'errorMsg' => false,
			'success' => true,
			'data' => json_encode($datas)
		));
	}
	
	
	public function _getTime($date) {
		return strtotime($date);
		/*
		$parts = explode('-', $date);
		$newDate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
		return strtotime($newDate);
		*/
	}

	/**
	 * Điểm danh học sinh
	 * @return boolean
	 */
	public function studentschedulepostAction() {
		$muster = @$_REQUEST['muster'];
		if(!$muster) {
			echo json_encode(array(
				'errorMsg' => 'Bạn chưa post lên điểm danh nào',
				'success' => true,
				'data' => false
			));
			return false;
		}
		foreach($muster as $classId => $students) {
			foreach($students as $studentId => $dates) {
				foreach($dates as $date => $status) {
					if ($items = _db()->select('*')
							->from('student_schedule')
							->where("classId=$classId and studentId=$studentId and studyDate='$date'")->result()) {
						$item = $items[0];
						_db()->update('student_schedule')
						->set(array(
								'classId' => $classId,
								'studentId' => $studentId,
								'studyDate' => $date,
								'status' => $status
							))->where('id=' . $item['id'])->result();
					} else {
						_db()->insert('student_schedule')
							->fields('classId,studentId,studyDate,status')
							->values(array(array(
								'classId' => $classId,
								'studentId' => $studentId,
								'studyDate' => $date,
								'status' => $status
							)))->result();
					}
				}
			}
		}
		echo json_encode(array(
			'errorMsg' => 'Cập nhật thành công',
			'success' => true,
			'data' => $muster
		));
	}
}

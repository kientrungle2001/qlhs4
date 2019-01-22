<?php
// --IGNORE--
require_once 'core/controller/Table.php';
class PzkAttributeTableController extends PzkTableController {
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
			'table' => 'student 
					left join `class_student` on student.id = class_student.studentId
					left join `classes` on class_student.classId = classes.id
					left join `student_order` on student.id = student_order.studentId
						and classes.id = student_order.classId',
			'fields' => 'student.*, group_concat(distinct(classes.name)) as classNames,
				group_concat(\'[\',student_order.payment_periodId, \']\') as periodIds',
			'groupBy' => 'student.id'
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
	);
	
	public $inserts = array(
		'attribute_set' => array('title', 'code', 'basedOn'),
	);
	
	public $filters = array(
		'student' => array(
			'name' => array('like' => 'student`.`name'),
			'classNames' => array('like' => array('having'=> true, 'name' => 'classNames')),
			'periodId' => array('like' => array('having'=> true, 'name' => 'periodIds')),
			'notlikeperiodId' => array(
				//'not like' => array('having'=> true, 'name' => 'periodIds'),
				'is null' => array('having'=> true, 'name' => 'periodIds'),
			),
			'phone' => array('like' => 'student`.`phone')
		),
		'student_order' => array(
			'classId' => array('=' => 'o`.`classId')
		)
	);
	
	public $constraints = array(
		'class_student' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId', 'studentId'), 'message' => 'Bản ghi đã tồn tại' )),
		'student' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('name', 'phone'), 'message' => 'Bản ghi đã tồn tại' )),
		'student_schedule' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId', 'studentId', 'studyDate'), 'message' => 'Bản ghi đã tồn tại' )),
		'teacher_schedule' => array('unique_key' => array('type' => 'key', 'key' 
				=> array('classId',  'studyDate'), 'message' => 'Bản ghi đã tồn tại' ))
				
	);
	
	public $deletes = array(
		'general_order' => array('student_order' => 'orderId'),
		'billing_order' => array('billing_detail_order' => 'orderId'),
	);
}
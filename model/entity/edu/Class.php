<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityEduClassModel extends PzkEntityModel {
	public $table = 'classes';
	public function getStudents($orderBy = 'student.name', $studentId = null) {
		$query = 'select student.*, student.note as studentNote, 
			class_student.note, class_student.id as classStudentId, 
			class_student.startClassDate, 
			class_student.endClassDate,
			class_student.classId,
			classes.startDate, classes.endDate
			from student 
				inner join class_student on student.id = class_student.studentId
				inner join classes on class_student.classId = classes.id				
			where class_student.classId=' . $this->getId() . ($studentId? ' and class_student.studentId='.$studentId: '' ) . ' order by ' . $orderBy;
		$students = _db()->query($query);
		$result = array();
		foreach($students as $student) {
			$obj = _db()->getEntity('edu.student');
			$obj->setData($student);
			$result[] = $obj;
		}
		return $result;
	}
	
	public function getPeriods() {
		if(!@$this->periods) {
			$conds = array('and');
			if($this->getStartDate() !== '0000-00-00') {
				$conds[] = array('or', array('gte', 'startDate', $this->getStartDate()), array('gt', 'endDate', $this->getStartDate()));
			}
			if($this->getEndDate() !== '0000-00-00') {
				$conds[] = array('or', array('lte', 'startDate', $this->getEndDate()), array('lt', 'endDate', $this->getEndDate()));
			}
			$conds[] = array('status', '1');
			
			$periods = _db()->useCB()->select('*')->fromPayment_period()
				->where($conds)->orderBy('startDate asc')->result('edu.period');
			$periodByIds = array();
			foreach($periods as $period) {
				$periodByIds[$period->getId()] = $period;
			}
			$this->periods = $periodByIds;	
			
		}
		return $this->periods;
	}
	
	public function getRawStudents() {
		
		if(!@$this->students) {
			$rows = _db()->useCB()->select('student.id, student.phone, student.name, student.note, class_student.endClassDate, class_student.startClassDate')
				->fromClass_student()
				->joinStudent('class_student.studentId=student.id')
				->whereClassId($this->getId())
				->orderBy('student.name asc')
				->result('edu.student');
			$students = array();
			foreach($rows as $row) {
				$students[$row->getId()] = $row;
			}
			$this->students = $students;	
		}
		return $this->students;
	}
	
	public function getStudentIdPaids() {
		$orders = _db()->useCB()->select('studentId')
			->fromStudent_order()
			->whereClassId($this->getId())
			->whereStatus('')
			->result();
		$payments = array();
		foreach($orders as $order) {
			$payments[$order['studentId']] = true;
		}
		$paymentEntity = _db()->getEntity('edu.payment');
		$paymentEntity->setPaids($payments);
		return $paymentEntity;
	}
	
	public function isVMT() {
		return $this->getSubjectId() == 3;
	}
	
	public function getSubject() {
		$subject = _db()->getTableEntity('subject')->load($this->getSubjectId());
		return $subject;
	}
	
	public function getAmountFormated() {
		return product_price($this->getAmount());
	}
	
	public function getSchedules($startDate, $endDate) {
		return _db()->useCB()->select('studyDate')->fromSchedule()
			->whereClassId($this->getId())
			->gteStudyDate($startDate)
			->ltStudyDate($endDate)
			->orderBy('studyDate asc')->result();
	}
	
	public function getSchedulesOfPeriods($periods) {
		$minStartDate = $this->getMinStartDate($periods);
		$maxEndDate = $this->getMaxEndDate($periods);
		return $this->getSchedules($minStartDate, $maxEndDate);
	}
	
	public function getStudentSchedules($periods) {
		
		$minStartDate = $this->getMinStartDate($periods);
		$maxEndDate = $this->getMaxEndDate($periods);
		
		$studentSchedules = _db()->useCB()
			->select('studentId, studyDate, status')
			->fromStudent_schedule()
			->whereClassId($this->getId())
			->gteStudyDate($minStartDate)
			->ltStudyDate($maxEndDate)
			->orderBy('studentId asc, studyDate asc')
			->result();
		return $studentSchedules;
	}
	
	public function getOffSchedules($periods) {
		
		$minStartDate = $this->getMinStartDate($periods);
		$maxEndDate = $this->getMaxEndDate($periods);
		
		$offScheduleConds = AA(
			AO(
				AA(AE('classId', $this->getId()), AE('type', 'class')), 
				AE('type', 'center')
			), 
			AGE('offDate', $minStartDate), 
			ALT('offDate', $maxEndDate)
		);
		$offSchedules = _db()->useCB()
				->select('*')
				->fromOff_schedule()
				->where($offScheduleConds)
				->orderBy('offDate asc');
		return $offSchedules->result();
	}
	
	public function getOrders($periods, $students) {
		$orders = _db()->useCB()
			->select('id, orderId, payment_periodId as periodId, studentId')
			->from('student_order')
			->where(array('and', array('classId', $this->getId()), array('status', '')))
			->inPayment_periodId(array_keys($periods))
			->inStudentId(array_keys($students))
			->result();
		return $orders;
	}
	
	public function getMinStartDate($periods) {
		$minStartDate = 0; 
		foreach($periods as $period) {
			if($minStartDate == 0 || $minStartDate > $period->getStartDate())
				$minStartDate = $period->getStartDate();
		}
		return $minStartDate;
	}
	
	public function getMaxEndDate($periods) {
		$maxEndDate = 0;
		foreach($periods as $period) {
			if($maxEndDate == 0 || $maxEndDate < $period->getEndDate())
				$maxEndDate = $period->getEndDate();
		}
		return $maxEndDate;
	}
	
	public function makeOrderStats() {
		$class = $this;
		$periods = $class->getPeriods();
		// lay danh sach hoc sinh
		$students = $class->getRawStudents();
	}
	
	public function makePaymentStats() {
		$class = $this;
		$periods = $class->getPeriods();
		// lay danh sach hoc sinh
		$students = $class->getRawStudents();
		
		// lay lich hoc cua lop trong cac ky
		$schedules = $class->getSchedulesOfPeriods($periods);
		
		// chia lich hoc theo cac ky
		foreach($periods as $period) {
			$period->importSchedules($schedules);
		}
		
		// duyet qua cac ky
			// duyet qua cac hoc sinh
				// dua ra cac buoi hoc cua hoc sinh
		foreach($periods as $period) {
			$period->importStudentSchedules($students);
		}
		
		
		
		// danh dau cac trang thai diem danh
		$studentSchedules = $class->getStudentSchedules($periods);
		foreach($periods as $period) {
			$period->markStudentSchedules($studentSchedules);
		}
		
		// lich nghi
		$offSchedules = $class->getOffSchedules($periods);
		
		// duyet qua cac lich nghi
		foreach($periods as $period) {
			$period->importOffSchedules($offSchedules);
		}
		
		// bat dau tinh so buoi hoc
		$lastPeriod = NULL;// ki thanh toan truoc
		foreach($periods as $periodId => $period) {
			$period->makeStats($lastPeriod, $class);
			$lastPeriod = $period;
		}
		
		// xem danh sach hoa don
		$orders = $class->getOrders($periods, $students);
		
		// tinh xem hoc sinh da thanh toan hoc phi chua
		foreach($periods as $period) {
			$period->markPaids($orders);
		}
	}
	
	public function makeTeacherStats() {
		$periods = $this->getPeriods();
		$schedules = $this->getTeacherSchedules();
		foreach($periods as $period) {
			$period->importTeacherSchedules($schedules);
		}
	}
	
	public function getTeacherSchedules() {
		return _db()->select('*')->fromTeacher_schedule()->whereClassId($this->getId())->result();
	}
	
	public function getTeacher() {
		if(!$this->getTeacherEntity()) {
			if($this->getTeacherId()) {
				$teacher = _db()->getEntity('edu.teacher')->load($this->getTeacherId());
				$this->setTeacherEntity($teacher);
			}
		}
		return $this->getTeacherEntity();
	}
	public function getTeacher2() {
		if(!$this->getTeacher2Entity()) {
			if($this->getTeacher2Id()) {
				$teacher = _db()->getEntity('edu.teacher')->load($this->getTeacher2Id());
				$this->setTeacher2Entity($teacher);
			}
		}
		return $this->getTeacher2Entity();
	}
	
	public function getVMTSchedules() {
		$rs = array();
		$schedules = _db()->select('*')->fromStudent_schedule()->whereClassId($this->getId())->result();
		foreach($schedules as $schedule) {
			$rs[$schedule['studentId']][$schedule['studyDate']]['status'] = $schedule['status'];
		}
		return $rs;
	}
}

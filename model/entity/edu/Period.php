<?php
require_once BASE_DIR . '/model/Entity.php';
class PzkEntityEduPeriodModel extends PzkEntityModel {
	public $table = 'payment_period';
	public function importSchedules($schedules) {
		$rs = array();
		foreach($schedules as $schedule) {
			if($schedule['studyDate'] >= $this->getStartDate() &&  $schedule['studyDate'] < $this->getEndDate()) {
				$rs[] = $schedule['studyDate'];
			}
		}
		$this->setSchedules($rs);
	}
	public function importStudentSchedules($students) {
		$rs = array();
		foreach($students as $student) {
			$studentScheduleDateCount = 0;
			if($this->getSchedules())
			foreach($this->getSchedules() as $studyDate) {
				if(($student->getStartClassDate()==='0000-00-00' or $studyDate >= $student->getStartClassDate())
					and
					($student->getEndClassDate()==='0000-00-00' or $studyDate < $student->getEndClassDate())) {
						if($studentScheduleDateCount == 0) {
							$rs[$student->getId()] = array();
						}
						$studentScheduleDateCount++;
						$rs[$student->getId()][$studyDate]['status'] = 0;
				}
			}
		}
		$this->setStudentSchedules($rs);
	}
	
	public function markStudentSchedules($studentSchedules) {
		$rs = $this->getStudentSchedules();
		foreach($studentSchedules as $studentSchedule){
			if(isset($rs[$studentSchedule['studentId']][$studentSchedule['studyDate']])) {
				$rs[$studentSchedule['studentId']][$studentSchedule['studyDate']]['status'] = $studentSchedule['status'];
			}
		}
		$this->setStudentSchedules($rs);
	}
	
	public function importOffSchedules($offSchedules) {
		$rs = $this->getStudentSchedules();
		foreach($offSchedules as $offSchedule) {
			if($offSchedule['offDate'] >= $this->getStartDate() && $offSchedule['offDate'] < $this->getEndDate()) {
				foreach($rs as $studentId => $schedules) {
					if(isset($rs[$studentId][$offSchedule['offDate']])){
						$rs[$studentId][$offSchedule['offDate']]['status'] = ($offSchedule['paymentType'] == 'immediate') ? '4' : '2';
					}
				}
			}
		}
		$this->setStudentSchedules($rs);
	}
	
	public function makeStats($lastPeriod, $class) {
		$studentSchedules = $this->getStudentSchedules();
		$rs = array();
		if($studentSchedules)
		foreach($studentSchedules as $studentId => $schedules) {
			for($i = 0; $i < 6; $i++) {
				$rs[$studentId][$i] = 0;
				foreach($schedules as $studyDate => $schedule) {
					if($schedule['status'] == $i) {
						$rs[$studentId][$i]++;
					}
				}
			}
			if($lastPeriod) {
				$lastStats = $lastPeriod->getStudentStats();
				$rs[$studentId][6] = @$lastStats[$studentId][2];
			}
			$rs[$studentId]['total'] = count($schedules);
			$rs[$studentId]['sobuoihoc'] = $rs[$studentId]['total'] - @$rs[$studentId]['4'];
			$amount = $this->getAmountOfClass($class);
			$lastAmount = 0;
			if($lastPeriod) {
				$lastAmount = $lastPeriod->getAmountOfClass($class);
			}
			$rs[$studentId]['hocphi'] = $amount * ($rs[$studentId]['total'] - @$rs[$studentId]['4']) - $lastAmount * @$rs[$studentId]['6'];
		}
		$this->setStudentStats($rs);
	}
	public function markPaids($orders) {
		$rs = $this->getStudentStats();
		foreach($orders as $order) {
			$periodId = $order['periodId'];
			if($periodId == $this->getId()) {
				$studentId = $order['studentId'];
				if(isset($rs[$studentId])) {
					$rs[$studentId]['orderId'] = $order['orderId'];
				}	
			}
			
		}
		$this->setStudentStats($rs);
	}
	public $amountOfClass = array();
	public function getAmountOfClass($class) {
		if(!isset($this->amountOfClass[$class->getId()])) {
			$tuition_fee = $this->getTuitionFee($class);
			if($tuition_fee) {
				$this->amountOfClass[$class->getId()] = $tuition_fee;
			} else {
				$this->amountOfClass[$class->getId()] = $class->getAmount();
			}
			
		}
		return $this->amountOfClass[$class->getId()];
	}
	
	public function getTuitionFee($class) {
		$tuition_fee = _db()->useCB()->select('*')
			->fromTuition_fee()
			->whereClassId($class->getId())
			->wherePeriodId($this->getId())
			->result_one();
		if($tuition_fee) {
			return $tuition_fee['amount'];
		}
		return NULL;
	}
	
	public function getStudentIdPaids($class, $students) {
		$orders = _db()->useCB()
			->select('id, orderId, payment_periodId as periodId, studentId, amount, created')
			->from('student_order')
			->whereClassId($class->getId())
			->wherePayment_periodId($this->getId())
			->inStudentId(array_keys($students))
			->whereStatus('')
			->result();
		$payments = array();
		foreach($orders as $order) {
			$payments[$order['studentId']] = $order;
		}
		$paymentEntity = _db()->getEntity('edu.payment');
		$paymentEntity->setPaids($payments);
		return $paymentEntity;
	}
	
	public function importTeacherSchedules($teacherSchedules) {
		$rs = array();
		$schedules = $this->getSchedules();
		$stats = array();
		if($schedules)
		foreach($teacherSchedules as $schedule) {
			if(in_array($schedule['studyDate'], $schedules)) {
				$rs[$schedule['studyDate']] = $schedule['teacherId'];
				$stats[$schedule['teacherId']] = 1 + @$stats[$schedule['teacherId']];
			}
		}
		
		$this->setTeacherSchedules($rs);
		$this->setTeacherStats($stats);
	}
	
	public function getStatOfTeacher($teacher) {
		$stats = $this->getTeacherStats();
		if($teacher) {
			return @$stats[$teacher->getId()];
		}
		return NULL;
	}
}
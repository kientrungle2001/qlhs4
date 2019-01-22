<?php
$class = $data->getClass();
?>
<!-- truong hop lop van mieu ta -->
<?php if($class->getSubjectId() == 3) {
		$students = $class->getRawStudents();
		// danh sách học sinh đã thanh toán
		$payments = $class->getStudentIdPaids();
		
	?>
	<a href="{url /demo/paymentstatPrint}?classId={? echo $class->getId()?}&periodId=0" target="_blank">Xem bản in</a>
	
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="9">{? echo $class->getName()?}</th>
		</tr>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>Học phí</th>
			<th>Trạng thái</th>
			
		</tr>
		<?php 
			$index = 0;
			$numberPaid = 0;
			$numberNonPaid = 0;
		?>
		{each $students as $student}	
		{? $index++; ?}
		<?php 
			// xet xem da thanh toan hay chua
			$status = '';
			if(isset($payments[$student->getId()])) { 
				$status = '<span style="color: green;">Đã thanh toán</span>'; 
				$numberPaid++;
			} else { 
				$status = '<span style="color: red;">Chưa thanh toán</span>'; 
				$numberNonPaid++;
			} ?>
		<tr>
			<td>{index}. {? echo $student->getName() ?}</td>
			<td>{? echo $student->getPhone() ?}</td>
			<td>{? echo product_price($class->getAmount()) ?}</td>
			<td>{status}</td>
		</tr>
		{/each}
	</table>
	<table>
	<tr><td>Sĩ số:</td><td> {index} học sinh</td></tr>
	<tr><td>Đã thanh toán:</td><td> {numberPaid} học sinh</td></tr>
	<tr><td>Chưa thanh toán:</td><td> {numberNonPaid} học sinh</td></tr>
	</table>
<?php } else { ?>
<div class="easyui-tabs" style="width:1100px;height:auto;padding: 5px;">
<?php
	// loc ra cac ky hoc cua lop
	$conds = array('and');
	if($class['startDate'] !== '0000-00-00') {
		$conds[] = array('or', array('gte', 'startDate', $class['startDate']), array('gt', 'endDate', $class['startDate']));
	}
	if($class['endDate'] !== '0000-00-00') {
		$conds[] = array('or', array('lte', 'startDate', $class['endDate']), array('lt', 'endDate', $class['endDate']));
	}
	$conds[] = array('status', '1');
	$periods = _db()->useCB()->select('*')->from('payment_period')
		->where($conds)->orderBy('startDate asc')->result();
	$periodByIds = array();
	foreach($periods as $period) {
		$periodByIds[$period['id']] = $period;
	}
	// lay danh sach hoc sinh
	$students = $data->getStudents();
	
	// lay lich hoc cua lop trong cac ky
	$scheduleConds = array('and');
	$scheduleConds[] = array('equal', 'classId', $class['id']);
	$scheduleConds[] = array('gte', 'studyDate', min_array($periods, 'startDate'));
	$scheduleConds[] = array('lt', 'studyDate', max_array($periods, 'endDate'));
	$schedules = _db()->useCB()->select('studyDate')->from('schedule')->where($scheduleConds)->orderBy('studyDate asc')->result();
	
	// chia lich hoc theo cac ky
	$periodSchedules = array();
	foreach($periods as $period) {
		$periodSchedules[$period['id']] = array();
	}
	foreach($schedules as $schedule) {
		foreach($periods as $period) {
			if($schedule['studyDate'] >= $period['startDate'] &&  $schedule['studyDate'] < $period['endDate']) {
				$periodSchedules[$period['id']][] = $schedule['studyDate'];
			}
		}
	}
	
	// duyet qua cac ky
		// duyet qua cac hoc sinh
			// dua ra cac buoi hoc cua hoc sinh
	$periodStudentSchedules = array();
	foreach($periods as $period) {
		$periodStudentSchedules[$period['id']] = array();
		foreach($students as $student) {
			$studentScheduleDateCount = 0;
			foreach($periodSchedules[$period['id']] as $studyDate) {
				if(($student['startClassDate']==='0000-00-00' or $studyDate >= $student['startClassDate'])
					and
					($student['endClassDate']==='0000-00-00' or $studyDate < $student['endClassDate'])) {
						if($studentScheduleDateCount == 0) {
							$periodStudentSchedules[$period['id']][$student['id']] = array();
						}
						$studentScheduleDateCount++;
						$periodStudentSchedules[$period['id']][$student['id']][$studyDate] = '0';
				}
			}
		}
	}
	
	// danh dau cac trang thai diem danh
	$studentScheduleConds = array('and');
	$studentScheduleConds[] = array('equal', 'classId', $class['id']);
	$studentScheduleConds[] = array('gte', 'studyDate', min_array($periods, 'startDate'));
	$studentScheduleConds[] = array('lt', 'studyDate', max_array($periods, 'endDate'));
	$studentSchedules = _db()->useCB()->select('studentId, studyDate, status')->from('student_schedule')->where($studentScheduleConds)->orderBy('studentId asc, studyDate asc')->result();
	
	foreach($studentSchedules as $studentSchedule){
		foreach($periods as $period) {
			if(isset($periodStudentSchedules[$period['id']][$studentSchedule['studentId']][$studentSchedule['studyDate']])) {
				$periodStudentSchedules[$period['id']][$studentSchedule['studentId']][$studentSchedule['studyDate']] = $studentSchedule['status'];
			}
		}
	}
	
	// lich nghi
	$offScheduleConds = array('and');
	$offScheduleConds[] = array(
		'or', 
		array(
			'and', 
			array('equal', 'classId', $class['id']),
			array('equal', 'type', 'class')
		),
		array('equal', 'type', 'center')
	);
	$offScheduleConds[] = array('gte', 'offDate', min_array($periods, 'startDate'));
	$offScheduleConds[] = array('lt', 'offDate', max_array($periods, 'endDate'));
	
	$scheduleDates = array();
	foreach($schedules as $schedule) {
		$scheduleDates[] = "'{$schedule['studyDate']}'";
	}
	$offScheduleConds[] = array('in', 'offDate', $scheduleDates);
	$offSchedules = _db()->useCB()->select('*')->from('off_schedule')->where($offScheduleConds)->orderBy('offDate asc');
	$offSchedules = $offSchedules->result();
	
	// duyet qua cac lich nghi
	foreach($periods as $period) {
		foreach($offSchedules as $offSchedule) {
			if($offSchedule['offDate'] >= $period['startDate'] && $offSchedule['offDate'] < $period['endDate']) {
				foreach($students as $student) {
					if(isset($periodStudentSchedules[$period['id']][$student['id']][$offSchedule['offDate']])){
						$periodStudentSchedules[$period['id']][$student['id']][$offSchedule['offDate']] = ($offSchedule['paymentType'] == 'immediate') ? '4' : '2';
					}
				}
			}
		}
	}
	
	// bat dau tinh so buoi hoc
	$periodStudentStats = array(); 
	$lastPeriodId = null; // ki thanh toan truoc
	foreach($periodStudentSchedules as $periodId => $stds) {
		$tuition_fee = _db()->useCB()->select('*')->from('tuition_fee')->where(array('and', array('classId', $class['id']), array('periodId', $periodId)))->result_one();
		foreach($stds as $studentId => $scheduleDates) {
			$statuses = array_values($scheduleDates);
			for($i = 0; $i < 6; $i++) {
				$periodStudentStats[$periodId][$studentId][$i] = count_array($statuses, $i);
			}
			// so buoi nghi tru tien thang truoc
			if($lastPeriodId) {
				$periodStudentStats[$periodId][$studentId][6] = @$periodStudentStats[$lastPeriodId][$studentId][2];
			}
			$periodStudentStats[$periodId][$studentId]['total'] = count($statuses);
			$periodStudentStats[$periodId][$studentId]['sobuoihoc'] = $periodStudentStats[$periodId][$studentId]['total'] - @$periodStudentStats[$periodId][$studentId]['4'] - @$periodStudentStats[$periodId][$studentId]['6'];
			$periodStudentStats[$periodId][$studentId]['hocphi'] = ($tuition_fee ? $tuition_fee['amount'] : $class['amount']) * $periodStudentStats[$periodId][$studentId]['sobuoihoc'];
		}
		$lastPeriodId = $periodId;
	}
	
	// xem danh sach hoa don
	$orderConds = array('and', 
		array('classId', $class['id']), 
		array('in','payment_periodId', array_keys($periodByIds)),
		array('in', 'studentId', array_keys($students))
	);
	$orders = _db()->useCB()->select('id, orderId, payment_periodId as periodId, studentId')->from('student_order')->where($orderConds)->result();
	
	// tinh xem hoc sinh da thanh toan hoc phi chua
	foreach($orders as $order) {
		$periodId = $order['periodId'];
		$studentId = $order['studentId'];
		if(isset($periodStudentStats[$periodId][$studentId])) {
			$periodStudentStats[$periodId][$studentId]['orderId'] = $order['orderId'];
		}
	}
	
	// hien thi bang thanh toan
	$periodCount = count(array_keys($periodStudentStats));
	$periodIndex = 0;
	foreach($periodStudentStats as $periodId => $stds) { 
	$periodIndex++;
	$period = $periodByIds[$periodId];
	$tuition_fee = _db()->useCB()->select('*')->from('tuition_fee')
			->where(array('and', 
				array('classId', $class['id']), 
				array('periodId', $periodId)))
			->result_one();
	?>
	<div title="{period[name]}" <?php if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?>>
	<a href="{url /demo/paymentstatPrint}?classId={class[id]}&periodId={period[id]}" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="14">{period[name]}</th>
		</tr>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>N/A</th>
			<th>CM</th>
			<th>NTT</th>
			<th>NKT</th>
			<th>KTT</th>
			<th>DH</th>
			<th>NLM</th>
			<th>Tổng</th>
			<th>Học phí</th>
			<th>Số buổi</th>
			<th>Thành tiền</th>
			<th>Trạng thái</th>
		</tr>
<?php
		$stdIndex = 0;
		$numberPaid = 0;
		$numberNonPaid = 0;
		foreach($stds as $studentId => $stdStat) { 
			$student = $students[$studentId];
			$stdIndex++;
			if(isset($stdStat['orderId'])) {
				$numberPaid++;
				$status = '<span style="color: green;">Đã thanh toán</span>';
			} else {
				$numberNonPaid++;
				$status = '<span style="color: red;">Chưa thanh toán</span>';
			}
			
		?>
		<tr>
			<th>{stdIndex}. {student[name]}</th>
			<th>{student[phone]}</th>
			<th>{stdStat[0]}</th>
			<th>{stdStat[1]}</th>
			<th>{stdStat[2]}</th>
			<th>{stdStat[3]}</th>
			<th>{stdStat[4]}</th>
			<th>{stdStat[5]}</th>
			<th>{stdStat[6]}</th>
			<th>{stdStat[total]}</th>
			<th>{? echo product_price($tuition_fee?$tuition_fee['amount'] : $class['amount']); ?}</th>
			<th>{stdStat[sobuoihoc]}</th>
			<th>{? echo product_price($stdStat['hocphi'])?}</th>
			<th>{status}</th>
		</tr>
<?php
		} ?>
		<tr>
			<td colspan="14">
				Sĩ số: {stdIndex}<br />
				Đã thanh toán : {numberPaid}<br />
				Chưa thanh toán : {numberNonPaid}<br />
			</td>
		</tr>
	</table>
	</div>
<?php
	}
?>
</div>
<?php } ?>
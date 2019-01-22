<?php 
	$class = $data->getClass();
	if($class['subjectId'] != 3) {
	$teachers = $data->getTeachers(@$class['teacherId'], @$class['teacher2Id']);
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
	$students = $data->getStudents(true);
	
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
				if($studentSchedule['status'] != 5)
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
	} ?>
<div class="easyui-tabs" style="width:1340px;height:auto;padding: 5px;">
<?php
	
	foreach($periodStudentSchedules as $periodId => $stds) { 
		$period = $periodByIds[$periodId];
?>

	<div title="{period[name]}">
	<a href="{url /demo/musterPrint}?classId={class[id]}&periodId={period[id]}" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
		<tr>
			<th>STT</th>
			<th>Họ tên</th>
			<th>Số điện thoại<br />
			Điểm danh cả lớp<br />
			Điểm danh giáo viên</th>
			<?php 
				$dates = $periodSchedules[$period['id']];
			?>
			{each $dates as $date}
			<th>{? echo date('d/m', strtotime($date))?}
			<br />
			<select id="muster_{class[id]}_{date}"
					onchange="submitClassMuster('{class[id]}', '{date}', this.value)">
				<option value="0">N/A</option>
				<option value="1">CM</option>
				<option value="2">NTT</option>
				<option value="3">NKT</option>
				<option value="4">KTT</option>
				<option value="5">DH</option>
			</select><br />
			<select id="teacher_{class[id]}_{date}" onchange="submitTeacherMuster('{class[id]}', '{date}', this.value)">
				<option value="0">---</option>
				<?php if (@$class['teacherId']) { 
					$teacher = $teachers[$class['teacherId']]; 
					$names = explode(' ', $teacher['name']);
					$name = array_pop($names);
					?>
					<option value="{class[teacherId]}">{name}</option>
				<?php } ?>
				<?php if (@$class['teacher2Id']) { 
					$teacher2 = $teachers[$class['teacher2Id']];
					$names = explode(' ', $teacher2['name']);
					$name2 = array_pop($names); ?>
					<option value="{class[teacher2Id]}">{name2}</option>
				<?php } ?>
			</select>
			</th>
			{/each}
		</tr>
<?php
		$stdIndex = 0;
		foreach($stds as $studentId => $stdSchedules) { 
			$student = $students[$studentId];
			$stdIndex++;
		?>
		<tr>
			<td>{stdIndex}</td>
			<td>{student[name]}</td>
			<td>{student[phone]}</td>
			{each $dates as $date}
			<td> {? if(isset($stdSchedules[$date])) { ?}<select class="muster_{class[id]}_{date}" id="muster_{class[id]}_{student[id]}_{date}" name="muster[{class[id]}][{student[id]}][{date}]"
					onchange="submitMuster('{class[id]}', '{student[id]}', '{date}', this.value)">
				<option value="0">N/A</option>
				<option value="1">CM</option>
				<option value="2">NTT</option>
				<option value="3">NKT</option>
				<option value="4">KTT</option>
				<option value="5">DH</option>
			</select><script type="text/javascript">
				$('#muster_{class[id]}_{student[id]}_{date}').val('{? echo $stdSchedules[$date]; ?}');
			</script>{? } else { ?}&nbsp;{? } ?}</td>
			{/each}
		</tr>
<?php	} ?>
	</table>
	</div>
<?php
	}
?>
</div>
<?php }  else { 
$students = $data->getStudents(true);
$stdIndex = 0;
	} ?>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
		<tr>
			<th>STT</th>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<?php for($i = 1; $i < 18; $i++) { ?>
			<th>Buổi {i}<br />
			<select id="muster_{class[id]}_{i}"
					onchange="submitClassMuster('{class[id]}', '{i}', this.value)">
				<option value="0">N/A</option>
				<option value="1">CM</option>
				<option value="2">NTT</option>
				<option value="3">NKT</option>
				<option value="4">KTT</option>
				<option value="5">DH</option>
			</select>
			</th>
			<?php } ?>
		</tr>
	{each $students as $student}
		{? $stdIndex++; ?}
		<tr>
			<td>{stdIndex}</td>
			<td>{student[name]}</td>
			<td>{student[phone]}</td>
			<?php for($i = 1; $i < 18; $i++) { ?>
			<td>
			<select class="muster_{class[id]}_{i}" id="muster_{class[id]}_{student[id]}_{i}" name="muster[{class[id]}][{student[id]}][{i}]"
					onchange="submitMuster('{class[id]}', '{student[id]}', '{i}', this.value)">
				<option value="0">N/A</option>
				<option value="1">CM</option>
				<option value="2">NTT</option>
				<option value="3">NKT</option>
				<option value="4">KTT</option>
				<option value="5">DH</option>
			</select><script type="text/javascript">
				$('#muster_{class[id]}_{student[id]}_{i}').val('');
			</script>
			</td>
			<?php } ?>
		</tr>
	{/each}
	</table>
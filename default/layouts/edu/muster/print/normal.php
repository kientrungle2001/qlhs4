<div class="easyui-tabs" style="width:1100px;height:auto;padding: 5px;">
{?
	$class = $data->getClass();
	
	$class->makePaymentStats();
	$class->makeTeacherStats();
	
	$teacher = $class->getTeacher();
	$teacher2 = $class->getTeacher2();
	
	$periods = $class->getPeriods();
	$students = $class->getRawStudents();
	
	// hien thi bang thanh toan
	$periodCount = count($periods);
	$periodIndex = 0;
?}
	{each $periods as $period}
	{? if($period->getId() == pzk_request()->getPeriodId()) {
			$hidden = 'display: block;';
		} else {  
			$hidden = 'display: none;';
		} ?}
	
	<div title="{? echo $period->getName()?}" style="{hidden}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
		<h3>Điểm danh lớp {? echo $class->getName() ?}</h3>
			{?  $schedules = $period->getSchedules();
			$stdSchedules = $period->getStudentSchedules(); 
			$teacherSchedules = $period->getTeacherSchedules(); 
			?}
			<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
			<tr>
				<th>STT</th>
				<th>Họ tên</th>
				<th>Số điện thoại
				{each $schedules as $date}
				<th>{? echo date('d/m', strtotime($date))?}
				</th>
				{/each}
			</tr>
			{? 
			$stdIndex = 0;
			foreach($stdSchedules as $studentId => $stdSchedule){ 
				$student = $students[$studentId];
				$stdIndex++;
				?}
				<tr>
					<td>{stdIndex}</td>
					<td>{? echo $student->getName(); ?}</td>
					<td>{? echo $student->getPhone(); ?}</td>
				{each $schedules as $date}
					<td>&nbsp;</td>
				{/each}
				</tr>
			{? } ?}
			</table>
	</div>
	{/each}
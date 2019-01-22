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
	<div title="{? echo $period->getName()?}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
		<a href="{url /demo/musterPrint}?classId={? echo $class->getId() ?}&periodId={? echo $period->getId()?}" target="_blank">Xem bản in</a>
			{?  $schedules = $period->getSchedules();
			$stdSchedules = $period->getStudentSchedules(); 
			$teacherSchedules = $period->getTeacherSchedules(); 
			?}
			<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
			<tr>
				<th>STT</th>
				<th>Họ tên</th>
				<th>Số điện thoại<br />
				Điểm danh giáo viên<br />
				Điểm danh cả lớp</th>
				{each $schedules as $date}
				<th>{? echo date('d/m', strtotime($date))?}
				<br />
				<select class="muster_teacher_{? echo $class->getId(); ?}_{? echo $period->getId(); ?}" id="teacher_{? echo $class->getId(); ?}_{date}" onchange="submitTeacherMuster('{? echo $class->getId(); ?}', '{date}', this.value)">
					<option value="0">---</option>
					{if $teacher}
						<option value="{? echo $teacher->getId(); ?}">{? echo $teacher->getLastName(); ?}</option>
					{/if}
					{if $teacher2}
						<option value="{? echo $teacher2->getId(); ?}">{? echo $teacher2->getLastName(); ?}</option>
					{/if}
				</select>
				{? if(isset($teacherSchedules[$date])) { ?}
				<script>
					$('#teacher_{? echo $class->getId(); ?}_{date}').val('{? echo $teacherSchedules[$date] ?}');
				</script>
				{? } ?}
				<br />
				<select id="muster_{? echo $class->getId(); ?}_{date}"
						onchange="submitClassMuster('{? echo $class->getId(); ?}', '{date}', this.value)">
					<option value="0">N/A</option>
					<option value="1">CM</option>
					<option value="2">NTT</option>
					<option value="3">NKT</option>
					<option value="4">KTT</option>
					<option value="5">DH</option>
				</select>
				</th>
				{/each}
				<th>
				Giáo viên<br />
				<select onchange="submitAllTeacherMuster('{? echo $class->getId(); ?}', '{? echo $period->getId(); ?}', this.value)">
					<option value="0">---</option>
					{if $teacher}
						<option value="{? echo $teacher->getId(); ?}">{? echo $teacher->getLastName(); ?}</option>
					{/if}
					{if $teacher2}
						<option value="{? echo $teacher2->getId(); ?}">{? echo $teacher2->getLastName(); ?}</option>
					{/if}
				</select><br />
				Học sinh</th>
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
					<td>
					{? if(isset($stdSchedule[$date])) { ?}<select class="muster_{? echo $class->getId() ?}_{date} muster_student_{? echo $class->getId() ?}_{? echo $period->getId() ?}_{? echo $student->getId() ?}" id="muster_{? echo $class->getId() ?}_{? echo $period->getId() ?}_{? echo $student->getId() ?}_{date}" name="muster[{? echo $class->getId() ?}][{? echo $period->getId() ?}][{? echo $student->getId() ?}][{date}]"
					onchange="submitMuster('{? echo $class->getId() ?}', '{? echo $student->getId() ?}', '{date}', this.value)">
				<option value="0">N/A</option>
				<option value="1">CM</option>
				<option value="2">NTT</option>
				<option value="3">NKT</option>
				<option value="4">KTT</option>
				<option value="5">DH</option>
			</select><script type="text/javascript">
				$('#muster_{? echo $class->getId() ?}_{? echo $period->getId() ?}_{? echo $student->getId() ?}_{date}').val("{? echo $stdSchedule[$date]['status']; ?}");
			</script>{? } else { ?}&nbsp;{? } ?}
					</td>
				{/each}
				<td>
					<select class="muster_{? echo $class->getId() ?}" id="muster_{? echo $class->getId() ?}_{? echo $student->getId() ?}" name="muster[{? echo $class->getId() ?}][{? echo $student->getId() ?}]"
					onchange="submitStudentMuster('{? echo $class->getId() ?}', '{? echo $period->getId() ?}', '{? echo $student->getId() ?}',  this.value)">
						<option value="0">N/A</option>
						<option value="1">CM</option>
						<option value="2">NTT</option>
						<option value="3">NKT</option>
						<option value="4">KTT</option>
						<option value="5">DH</option>
					</select>
				</td>
				</tr>
			{? } ?}
			</table>
	</div>
	{/each}
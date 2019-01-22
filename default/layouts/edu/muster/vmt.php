{?
	$class = $data->getClass();	
	$teacher = $class->getTeacher();
	$teacher2 = $class->getTeacher2();
	
	$students = $class->getRawStudents();
	$index = 1;
	$stdSchedules = $class->getVMTSchedules();
?}
<a href="{url /demo/musterPrint}?classId={? echo $class->getId() ?}" target="_blank">Xem bản in</a>
<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse: collapse; margin: 15px; width: 100%;">
<tr>
	<th rowspan="2">STT</th>
	<th rowspan="2">Họ và tên</th>
	<th rowspan="2">Số Điện Thoại</th>
	<th colspan="17">Điểm danh</th>
</tr>
<tr>
	
	{? for($i = 1; $i < 18; $i++) { ?}
	<td>
	Buổi {i}<br />
	<select id="muster_{? echo $class->getId(); ?}_1970-01-{? echo ($i < 10) ? '0':'' ?}{i}"
						onchange="submitClassMuster('{? echo $class->getId(); ?}', '1970-01-{? echo ($i < 10) ? '0':'' ?}{i}', this.value)">
					<option value="0">N/A</option>
					<option value="1">CM</option>
					<option value="2">NTT</option>
					<option value="3">NKT</option>
					<option value="4">KTT</option>
					<option value="5">DH</option>
				</select></td>
	{? } ?}
</tr>
{each $students as $student}
{? $stdSchedule = @$stdSchedules[$student->getId()]; ?}
<tr>
	<td>{index}</td>
	<td>{? echo $student->getName();?}</td>
	<td>{? echo $student->getPhone();?}</td>
	{? for($i = 1; $i < 18; $i++) { ?}
	<td><select id="muster_{? echo $class->getId(); ?}_1970-01-{? echo ($i < 10) ? '0':'' ?}{i}"
						onchange="submitMuster('{? echo $class->getId(); ?}','{? echo $student->getId(); ?}', '1970-01-{? echo ($i < 10) ? '0':'' ?}{i}', this.value)">
					<option value="0">N/A</option>
					<option value="1">CM</option>
					<option value="2">NTT</option>
					<option value="3">NKT</option>
					<option value="4">KTT</option>
					<option value="5">DH</option>
				</select>
				<script type="text/javascript">
				$('#muster_{? echo $class->getId() ?}_{? echo $student->getId() ?}_1970-01-{? echo ($i < 10) ? '0':'' ?}{i}').val("{? echo @$stdSchedule['1970-01-' . (($i < 10) ? '0':'').$i]['status']; ?}");
			</script>
				</td>
	{? } ?}
</tr>
{? $index ++ ?}
{/each}
</table>
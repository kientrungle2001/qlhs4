{?
	$class = $data->getClass();	
	$teacher = $class->getTeacher();
	$teacher2 = $class->getTeacher2();
	
	$students = $class->getRawStudents();
	$index = 1;
	$stdSchedules = $class->getVMTSchedules();
?}
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
	{i}</td>
	{? } ?}
</tr>
{each $students as $student}
{? $stdSchedule = @$stdSchedules[$student->getId()]; ?}
<tr>
	<td>{index}</td>
	<td>{? echo $student->getName();?}</td>
	<td>{? echo $student->getPhone();?}</td>
	{? for($i = 1; $i < 18; $i++) { ?}
	<td>&nbsp;</td>
	{? } ?}
</tr>
{? $index ++ ?}
{/each}
</table>
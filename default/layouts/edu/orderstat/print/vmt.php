<?php
$class = $data->getClass();
$students = $class->getRawStudents();
// danh sách học sinh đã thanh toán
$payment = $class->getStudentIdPaids();
?>
<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
	<tr>
		<td colspan="9">{? echo $class->getName()?}</td>
	</tr>
	<tr>
		<td>Họ tên</td>
		<td>Số điện thoại</td>
		<td>Học phí</td>
		<td>Trạng thái</td>
		
	</tr>
	{? $index = 0; ?}
	{each $students as $student}
	{? $index++; ?}
	<tr>
		<td>{index}. {? echo $student->getName(); ?}</td>
		<td>{? echo $student->getPhone(); ?}</td>
		<td>{? echo $class->getAmountFormated(); ?}</td>
		<td>{? echo $payment->getStatus($student); ?}</td>
	</tr>
	{/each}
</table>
<table>
	<tr><td>Sĩ số:</td><td> {index} học sinh</td></tr>
	<tr><td>Đã thanh toán:</td><td> {? echo $payment->getNumberOfPaids(); ?} học sinh</td></tr>
	<tr><td>Chưa thanh toán:</td><td> {? echo $payment->getNumberOfNonPaids(); ?} học sinh</td></tr>
</table>
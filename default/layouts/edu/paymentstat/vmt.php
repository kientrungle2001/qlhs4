<?php
$class = $data->getClass();
$students = $class->getRawStudents();
// danh sách học sinh đã thanh toán
$payment = $class->getStudentIdPaids();
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
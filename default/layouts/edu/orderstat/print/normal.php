<div class="easyui-tabs" style="width:1100px;height:auto;padding: 5px;">
{?
	$class = $data->getClass();	
	$class->makeOrderStats();
	$periods = $class->getPeriods();
	$students = $class->getRawStudents();
	
	// hien thi bang thanh toan
	$periodCount = count($periods);
	$periodIndex = 0;
	$subject = $class->getSubject();
?}
	{each $periods as $period}
	{? 	
	if($period->getId() !== pzk_request('periodId')) continue;
	$payment = $period->getStudentIdPaids($class, $students); $periodIndex++; ?}
	<div title="{? echo $period->getName()?}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="14">Môn {? echo $subject->getName()?} - Lớp {? echo $class->getName()?} - {? echo $period->getName()?}</th>
		</tr>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>Học phí</th>
			<th>Trạng thái</th>
                        <th>Ngày in Hóa đơn</th>
		</tr>
	{? 	 
		$stdIndex = 0;$total = 0;
		foreach($students as $student) {   
		$stdIndex++;
		$total += $payment->getRawAmount($student);
		?}
		<tr>
			<td>{stdIndex}. {? echo $student->getName() ?}</td>
			<td>{? echo $student->getPhone() ?}</td>
			<td>{? echo $payment->getAmount($student); ?}</td>
			<td>{? echo $payment->getStatus($student); ?}</td>
                        <td>{? echo $payment->getCreated($student); ?}</td>
		</tr>
	{? 	} ?}
		<tr>
			<td colspan="2"><strong>Tổng cộng</strong></td>
			<td colspan="2"><strong>{? echo product_price($total); ?}</strong></td>
		</tr>
	</table>
	</div>
	{/each}
</div>
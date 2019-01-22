<div class="easyui-tabs" style="width:1100px;height:auto;padding: 5px;">
{?
	$class = $data->getClass();	
	$class->makeOrderStats();
	$periods = $class->getPeriods();
	$students = $class->getRawStudents();
	
	// hien thi bang thanh toan
	$periodCount = count($periods);
	$periodIndex = 0;
?}
	{each $periods as $period}
	{? 	$payment = $period->getStudentIdPaids($class, $students); $periodIndex++; ?}
	<div title="{? echo $period->getName()?}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
	<a href="{url /demo/orderstatPrint}?classId={? echo $class->getId() ?}&periodId={? echo $period->getId()?}" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="14">{? echo $period->getName()?}</th>
		</tr>
		<tr>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>Học phí</th>
			<th>Trạng thái</th>
                        <th>Ngày in Hóa đơn</th>
						<th>Ghi chú</th>
		</tr>
	{? 	 
		$stdIndex = 0;
		foreach($students as $student) {   
		$stdIndex++;
		?}
		<tr>
			<th>{stdIndex}. {? echo $student->getName() ?}</th>
			<th>{? echo $student->getPhone() ?}</th>
			<th>{? echo $payment->getAmount($student); ?}</th>
			<th>{? echo $payment->getStatus($student); ?}</th>
                        <th>{? echo $payment->getCreated($student); ?}</th>
						<th>{? echo $student->getNote() ?}</th>
		</tr>
	{? 	} ?}
	</table>
	</div>
	{/each}
</div>
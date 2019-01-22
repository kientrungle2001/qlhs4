
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
	{? 	$payment = $period->getStudentIdPaids($class, $students); $periodIndex++; ?}
	<div title="{? echo $period->getName()?}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
	<a href="{url /demo/paymentstatPrint}?classId={? echo $class->getId() ?}&periodId={? echo $period->getId()?}" target="_blank">Xem bản in</a>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th colspan="14">{? echo $period->getName()?}</th>
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
	{? 	$stds = $period->getStudentStats(); $stdIndex = 0; $tonghocphi = 0; $tongdatt = 0; $tongchuatt = 0;
		if($stds) foreach($stds as $studentId => $stdStat) {  $student = $students[$studentId]; $stdIndex++; 
		$tonghocphi += $stdStat['hocphi'];
		if($payment->isPaid($student)) {
			$tongdatt += $stdStat['hocphi'];
		} else {
			$tongchuatt += $stdStat['hocphi'];
		}
		?}
		<tr>
			<th>{stdIndex}. {? echo $student->getName() ?}</th>
			<th>{? echo $student->getPhone() ?}</th>
			<th>{stdStat[0]}</th>
			<th>{stdStat[1]}</th>
			<th>{stdStat[2]}</th>
			<th>{stdStat[3]}</th>
			<th>{stdStat[4]}</th>
			<th>{stdStat[5]}</th>
			<th>{stdStat[6]}</th>
			<th>{stdStat[total]}</th>
			<th>{? echo product_price($period->getAmountOfClass($class)); ?}</th>
			<th>{stdStat[sobuoihoc]}</th>
			<th>{? echo product_price($stdStat['hocphi'])?}</th>
			<th>{? echo $payment->getStatus($student); ?}</th>
		</tr>
	{? 	} ?}
		<tr>
			<td colspan="14">
				Sĩ số: {stdIndex}<br />
				Đã thanh toán : {? echo $payment->getNumberOfPaids(); ?}<br />
				Chưa thanh toán : {? echo $payment->getNumberOfNonPaids(); ?}<br />
				Tổng học phí: {? echo product_price($tonghocphi); ?}<br />
				Tổng học phí đã thanh toán: {? echo product_price($tongdatt); ?}<br />
				Tổng học phí chưa thanh toán: {? echo product_price($tongchuatt); ?}<br />
			</td>
		</tr>
	</table>
	
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<th>Thống kê</th>
			<th>Giáo viên 1</th>
			<th>Giáo viên 2</th>
		</tr>
		<tr>
			<th>Họ và tên</th>
			<td>{? if($teacher) { echo $teacher->getName(); } ?}</td>
			<td>{? if($teacher2) { echo $teacher2->getName(); } ?}</td>
		</tr>
		<tr>
			<th>Số buổi dạy</th>
			<td>{? echo $stat1 = $period->getStatOfTeacher($teacher);?}</td>
			<td>{? echo $stat2 = $period->getStatOfTeacher($teacher2);?}</td>
		</tr>
		{? $totalstat = $stat1 + $stat2; 
		if(!$totalstat) {
			$totalstat = $stat1 = count($period->getSchedules());
		}
		?}
		<tr>
			<th>Tổng học phí</th>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tonghocphi: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tonghocphi: 0);?}</td>
		</tr>
		<tr>
			<th>Tổng học phí đã thanh toán</th>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongdatt: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tongdatt: 0);?}</td>
		</tr>
		<tr>
			<th>Tổng học phí chưa thanh toán</th>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongchuatt: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tongchuatt: 0);?}</td>
		</tr>
		<tr>
			<th>Trả lương theo học phí đã thanh toán</th>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongdatt * $teacher->getSalary() / 100: 0);?}</td>
			<td>{? echo $teacher2 ? product_price($totalstat? ($stat2 / $totalstat) * $tongdatt * $teacher2->getSalary() / 100: 0): 0;?}</td>
		</tr>
	</table>
	</div>
	{/each}
</div>
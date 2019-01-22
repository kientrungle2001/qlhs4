
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
	{? 	$payment = $period->getStudentIdPaids($class, $students); $periodIndex++;
		if($period->getId() == pzk_request()->getPeriodId()) {
			$hidden = 'display: block;';
		} else {
			$hidden = 'display: none;';
		}
	?}
	<div title="{? echo $period->getName()?}" style="{hidden}" {? if($periodCount==$periodIndex) { echo 'data-options="selected: true"'; } ?}>
	<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;width: 1000px;">
		<tr>
			<td colspan="14">Kỳ học {? echo $period->getName()?} - Lớp {? echo $class->getName() ?}</td>
		</tr>
		<tr>
			<td>Họ tên</td>
			<td>Số điện thoại</td>
			<td>N/A</td>
			<td>CM</td>
			<td>NTT</td>
			<td>NKT</td>
			<td>KTT</td>
			<td>DH</td>
			<td>NLM</td>
			<td>Tổng</td>
			<td>Học phí</td>
			<td>Số buổi</td>
			<td>Thành tiền</td>
			<td>Trạng thái</td>
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
			<td>{stdIndex}. {? echo $student->getName() ?}</td>
			<td>{? echo $student->getPhone() ?}</td>
			<td>{stdStat[0]}</td>
			<td>{stdStat[1]}</td>
			<td>{stdStat[2]}</td>
			<td>{stdStat[3]}</td>
			<td>{stdStat[4]}</td>
			<td>{stdStat[5]}</td>
			<td>{stdStat[6]}</td>
			<td>{stdStat[total]}</td>
			<td>{? echo product_price($period->getAmountOfClass($class)); ?}</td>
			<td>{stdStat[sobuoihoc]}</td>
			<td>{? echo product_price($stdStat['hocphi'])?}</td>
			<td>{? echo $payment->getStatus($student); ?}</td>
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
			<td>Thống kê</td>
			<td>Giáo viên 1</td>
			<td>Giáo viên 2</td>
		</tr>
		<tr>
			<td>Họ và tên</td>
			<td>{? if($teacher) { echo $teacher->getName(); } ?}</td>
			<td>{? if($teacher2) { echo $teacher2->getName(); } ?}</td>
		</tr>
		<tr>
			<td>Số buổi dạy</td>
			<td>{? echo $stat1 = $period->getStatOfTeacher($teacher);?}</td>
			<td>{? echo $stat2 = $period->getStatOfTeacher($teacher2);?}</td>
		</tr>
		{? $totalstat = $stat1 + $stat2; 
		if(!$totalstat) {
			$totalstat = $stat1 = count($period->getSchedules());
		}
		?}
		<tr>
			<td>Tổng học phí</td>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tonghocphi: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tonghocphi: 0);?}</td>
		</tr>
		<tr>
			<td>Tổng học phí đã thanh toán</td>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongdatt: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tongdatt: 0);?}</td>
		</tr>
		<tr>
			<td>Tổng học phí chưa thanh toán</td>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongchuatt: 0);?}</td>
			<td>{? echo product_price($totalstat? ($stat2 / $totalstat) * $tongchuatt: 0);?}</td>
		</tr>
		<tr>
			<td>Trả lương theo học phí đã thanh toán</td>
			<td>{? echo product_price($totalstat? ($stat1 / $totalstat) * $tongdatt * $teacher->getSalary() / 100: 0);?}</td>
			<td>{? echo $teacher2 ? product_price($totalstat? ($stat2 / $totalstat) * $tongdatt * $teacher2->getSalary() / 100: 0): 0;?}</td>
		</tr>
	</table>
	</div>
	{/each}
</div>
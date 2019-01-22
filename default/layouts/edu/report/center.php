<h2>Báo cáo doanh thu theo giáo viên</h2>
<table border="1" style="width: 1024px; border-collapse: collapse;">

<?php
$summary = $data->getTeacherSummary();
?>
<?php foreach($summary as $studyMonth => $teacherData) { ?>

<tr>
	<th colspan="7">
		Kỳ {studyMonth}
	</th>
</tr>
<tr>
<th>Lớp</th>
<th>Số buổi</th>
<th>Số HS</th>
<th>ĐD</th>
<th>Doanh thu</th>
<th>Trả lương</th>
<th>Doanh thu TT</th>
</tr>
<?php 
$countStudyDateTotalTotal = 0;
$countStudentTotalTotal = 0;
$statusCountTotalTotal = 0;
$classTotalTotalTotal = 0;
$teacherTotalTotalTotal = 0;
$centerTotalTotalTotal = 0;
foreach($teacherData as $teacherName => $classData) { ?>
<tr>
	<th colspan="7">
		{teacherName}
	</th>
</tr>

<?php 
$countStudyDateTotal = 0;
$countStudentTotal = 0;
$statusCountTotal = 0;
$classTotalTotal = 0;
$teacherTotalTotal = 0;
$centerTotalTotal = 0;
foreach($classData as $className => $class) { 
$countStudyDateTotal += $class['countStudyDate'];
$countStudentTotal += $class['countStudent'];
$statusCountTotal += $class['statusCount'];
$classTotalTotal += $class['classTotal'];
$teacherTotalTotal += $class['teacherTotal'];
$centerTotalTotal += $class['centerTotal'];
?>
<tr>
<td>{className}</td>
<td>{class[countStudyDate]}</td>
<td>{class[countStudent]}</td>
<td>{class[statusCount]}</td>
<td>{? echo product_price( $class['classTotal'] ) ?}</td>
<td>{? echo product_price($class['teacherTotal']) ?}</td>
<td>{? echo product_price( $class['centerTotal']) ?}</td>
</tr>
<?php } 
$countStudyDateTotalTotal += $countStudyDateTotal;
$countStudentTotalTotal += $countStudentTotal;
$statusCountTotalTotal += $statusCountTotal;
$classTotalTotalTotal += $classTotalTotal;
$teacherTotalTotalTotal += $teacherTotalTotal;
$centerTotalTotalTotal += $centerTotalTotal;
?>
<tr>
<th>Tổng cộng: </th>
<td>{countStudyDateTotal}</td>
<td>{countStudentTotal}</td>
<td>{statusCountTotal}</td>
<td>{? echo product_price($classTotalTotal) ?}</td>
<td>{? echo product_price($teacherTotalTotal) ?}</td>
<td>{? echo product_price($centerTotalTotal) ?}</td>
</tr>
<?php } ?>
<tr>
<th>Tổng kỳ {studyMonth}: </th>
<td>{countStudyDateTotalTotal}</td>
<td>{countStudentTotalTotal}</td>
<td>{statusCountTotalTotal}</td>
<td>{? echo product_price($classTotalTotalTotal) ?}</td>
<td>{? echo product_price($teacherTotalTotalTotal) ?}</td>
<td>{? echo product_price($centerTotalTotalTotal) ?}</td>
</tr>
<?php } ?>
</table>
<br /><br /><br />
<?php 
$summary = $data->getSubjectSummary();
?>
<h2>Báo cáo doanh thu theo môn học</h2>
<table border="1" style="width: 1024px; border-collapse: collapse;">
<?php 
$center_total = 0;
foreach($summary as $studyMonth => $studyData) { 
?>

<tr>
	<th colspan="6">
	Kỳ {studyMonth}
	</th>
</tr>

<?php 
$period_total = 0;
foreach($studyData as $subjectName => $subjectData) { 
?>
<tr>
	<th colspan="6">
	Báo cáo doanh thu theo môn học {subjectName}
	</th>
</tr>

<tr>
	<th>Lớp</th>
	<th>Số học sinh</th>
	<th>Điểm danh</th>
	<th>Tổng số buổi</th>
	<th>Học phí/buổi</th>
	<th>Thành tiền</th>
</tr>
<?php 
$total = 0;
foreach($subjectData as $className => $class) { 
$subTotal = $class['classAmount'] * $class['statusCount'];
?>
<tr>
	<td>{className}</td>
	<td>{class[studentCount]}</td>
	<td>{class[statusCount]}</td>
	<td>{class[studyCount]}</td>
	<td>{? echo product_price($class['classAmount']) ?}</td>
	<td>{? echo product_price($subTotal) ?}</td>
</tr>
<?php 
$total += $subTotal;
}
?>
<tr>
	<td colspan="5" align="right">Tổng theo môn {subjectName}: </td>
	<td>{? echo product_price($total) ?}</td>
</tr>
<?php 
$period_total += $total;
} ?>
<tr>
	<td colspan="5" align="right">Tổng theo kỳ {studyMonth}: </td>
	<td>{? echo product_price($period_total) ?}</td>
</tr>
<?php 
$center_total += $period_total;
} ?>
<tr>
	<td colspan="5" align="right">Tổng cộng: </td>
	<td>{? echo product_price($center_total) ?}</td>
</tr>
</table>
<hr />
<?php
$summary = $data->getSummary();
$statuses = array('Chưa ĐD', 'CM', 'NTT', 'NKT');
?>
<?php foreach($summary as $className => $classData) { ?>
<h2>Báo cáo doanh thu theo lớp {className}</h2>
<?php foreach($classData as $studyMonth => $studyData) { 
$total = 0;
?>
<h3>Kỳ {studyMonth}</h3>
<table border="1" style="width: 1024px; border-collapse: collapse;">
<tr>
	<td>Tên học sinh</td>
	<td>Điểm danh</td>
	<td>Tổng số buổi</td>
	<td>Học phí/buổi</td>
	<td>Thành tiền</td>
</tr>
<?php foreach($studyData as $studentName => $studentData) { ?>
<tr>
	<td>{studentName}</td>
	<td>
	<?php 
	$statusTotal = 0;
	$lastRow = null;
	foreach($studentData as $statusId => $row) { ?>
	<?php echo $statuses[$statusId]?>: {row[statusCount]}
	<?php 
		if($statusId == 1 or $statusId == 3) {
			$statusTotal += $row['statusCount'];
		}
		$lastRow = $row;
		
	}
	$subTotal = $lastRow['classAmount'] * $statusTotal;
	$total += $subTotal;
	?>
	</td>
	<td>{statusTotal}</td>
	<td>{? echo product_price($lastRow['classAmount']) ?}</td>
	<td>{? echo product_price($subTotal)?}</td>
</tr>
<?php } ?>
<tr>
	<td colspan="4" align="right">Tổng tiền: </td>
	<td>{? echo product_price($total) ?}</td>
</tr>
</table>
<?php } ?>
<?php } ?>
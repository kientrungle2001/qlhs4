<?php 
$summary = $data->getSummary();
?>
<?php foreach($summary as $subjectName => $subjectData) { ?>
<h2>Báo cáo doanh thu theo môn học {subjectName}</h2>
<?php 
$total = 0;
foreach($subjectData as $studyMonth => $studyData) { ?>
<h3>Kỳ {studyMonth}</h3>
<table border="1" style="width: 1024px; border-collapse: collapse;">
<tr>
	<td>Lớp</td>
	<td>Số học sinh</td>
	<td>Điểm danh</td>
	<td>Tổng số buổi</td>
	<td>Học phí/buổi</td>
	<td>Thành tiền</td>
</tr>
<?php 
$subTotal = 0;
foreach($studyData as $className => $class) { 
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
	<td colspan="5" align="right">Tổng cộng: </td>
	<td>{? echo product_price($total) ?}</td>
</tr>
</table>
<?php } ?>
<?php } ?>
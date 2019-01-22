
<?php
$summary = $data->getSummary();
$summaryAll = $data->getSummaryAll();
$summaryTeacher2 = array();
?>
<?php foreach($summaryAll['teachers'] as $teacher):?>
<?php 
$classes = $summaryAll['summary'][$teacher['id']]['classes'];
$summaryTable = array();

foreach($classes as $class) 
{ 
if($class['teacher2Id']) {
	$teacher2 = _db()->select('name')->from('teacher')->where('id='.$class['teacher2Id'])->result_one();
	$teacher2 = $teacher2['name'];	
} else {
	$teacher2 = 'Nobody';
}

?>
<?php 
	$periods = $summaryAll['summary'][$teacher['id']]['periods'][$class['id']];
	$stat = $summaryAll['summary'][$teacher['id']]['stat'][$class['id']];
?>
{each $periods as $period}
	<?php $stdStats = $stat[$period['id']]; $tonghocphi = 0; $tongdatt = 0;
	
	?>
	{each $stdStats as $stdStat}
		<?php 
			$tonghocphi += $stdStat['hocphi'];
			if(isset($stdStat['orderId'])){
				$tongdatt+= $stdStat['hocphi'];
			}
			$summaryTeacher2[$teacher['name']][$period['name']][$teacher2]['tong'] = 
				@$summaryTeacher2[$teacher['name']][$period['name']][$teacher2]['tong']
				+ $stdStat['hocphi'];
			if(isset($stdStat['orderId'])){
				$summaryTeacher2[$teacher['name']][$period['name']][$teacher2]['tongdatt'] = 
				@$summaryTeacher2[$teacher['name']][$period['name']][$teacher2]['tongdatt']
				+ $stdStat['hocphi'];
			}
		?>
	{/each}
	<?php 
		$summaryTable[$teacher['name']][$period['name']][$class['name']]['tong'] = $tonghocphi;
		$summaryTable[$teacher['name']][$period['name']][$class['name']]['tongdatt'] = $tongdatt;
		$summaryTable[$teacher['name']][$period['name']][$class['name']]['teacher2'] = $teacher2;
	?>
{/each}
<?php
}
?>
<?php endforeach;?>
<?php foreach($summaryTable as $teacherName => $period):?>
	<h2>{teacherName}</h2>
	<?php foreach($period as $periodName => $class):?>
	<h3>{periodName}</h3>
	<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
		<tr>
			<th>Tên lớp - GV2</th>
			<th>Tổng cộng theo điểm danh</th>
			<th>Tổng cộng theo hóa đơn</th>
		</tr>
		<?php 
		$sum = 0;
		$sumdatt = 0;
		foreach($class as $className => $classStat):
			$sum += $classStat['tong'];
			$sumdatt += $classStat['tongdatt'];
		?>
		<tr>
			<td>{className} - {classStat[teacher2]}</td>
			<td>{? echo product_price($classStat['tong']); ?}</td>
			<td>{? echo product_price($classStat['tongdatt']); ?}</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td>Tổng cộng</td>
			<td>{? echo product_price($sum); ?}</td>
			<td>{? echo product_price($sumdatt); ?}</td>
		</tr>
	</table>
	
	<?php 
		$teacherSummary = $summaryTeacher2[$teacherName][$periodName];
	?>
	<br />
		<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
		<tr>
			<th>Giáo viên 2</th>
			<th>Tổng theo điểm danh</th>
			<th>Tổng theo hóa đơn</th>
		</tr>
		
		<?php foreach($teacherSummary as $teacherName => $teacherSummaryDetail):?>
		<tr>
		<td>{teacherName}</td><td>{? echo product_price($teacherSummaryDetail['tong']); ?}</td><td>{? echo product_price($teacherSummaryDetail['tongdatt']); ?}</td>
		</tr>
		<?php endforeach;?>
		
		</table>
	<?php endforeach;?>
	
<?php endforeach;?>
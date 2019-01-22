<?php $student = $data->getDetail();?>
<div id="student_detail_div">
<div class="student_detail">
<form>
	<div class="left-column">
		<div class="left-handside">Họ và tên: </div><div class="right-handside">{student[name]}</div><div class="clear"></div>
		<div class="left-handside">Ngày sinh:</div><div class="right-handside">{student[birthDate]}</div><div class="clear"></div>
		<div class="left-handside">Số điện thoại:</div><div class="right-handside">{student[phone]}</div><div class="clear"></div>
	</div>
	<div class="right-column">
		<div class="left-handside">Trường học:</div><div class="right-handside">{student[school]}</div><div class="clear"></div>
		<div class="left-handside">Địa chỉ nhà:</div><div class="right-handside">{student[address]}</div><div class="clear"></div>
		<div class="left-handside">Lớp học:</div><div class="right-handside">{student[classNames]}</div><div class="clear"></div>
	</div>
	<div class="clear"></div>
</form>
</div>
<div class="easyui-tabs" style="width:600px;height:auto;">
<?php 

$classIds = array();
$class_periods = array();
$class_period_mustertotals = array();
$class_period_discounts = array();
$class_period_prices = array();
$classPrices = array();
$class_discount_reasons = array();
foreach ($student['classes'] as $class) { 
	if(strpos($class['name'], 'M') === false) {
		$classIds[] = $class['id'];
		$classPrices[] = $class['amount'];
	}
?>

<div title="Lớp {class[name]} {? echo $class['startClassDate'] == '0000-00-00' ?'': ' - Start: '.date('d/m', strtotime($class['startClassDate'])) ?}{? echo $class['endClassDate'] == '0000-00-00' ?'': ' - End: ' . date('d/m', strtotime($class['endClassDate'])) ?}">
	<?php 
	if(strpos($class['name'], 'M') !== false) { 
		$order = _db()->useCB()->select('orderId')->fromStudent_order()
			->whereStudentId($student['id'])
			->whereClassId($class['id'])
			->wherePayment_periodId('0');
		$order = $order->result_one();
		
	?>
		<h2>Văn miêu tả</h2>
		<div class="left-handside">
		<?php if ($order) { ?> <a href="<?php echo BASE_URL; ?>/index.php/order/detail?id={order[orderId]}" target="_blank">Xem hóa đơn</a> <?php } else { ?>
		<a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&classIds={class[id]}&studentId={student[id]}&periodId=0&prices={class[amount]}&amounts={class[amount]}&discounts=0&musters=1&discount_reasons=" target="_blank">Tạo hóa đơn</a>
		<?php } ?>
		</div>
		<div class="right-handside"></div><div class="clear"></div>
</div>
<?php
		continue;
	}?>
	<div class="easyui-accordion" style="width:598px;height:auto;">
<?php
	$displayPeriod = true;
	foreach($class['periods'] as $period) { ?>
	<?php if($class['startDate'] !== '0000-00-00' && $class['startDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endDate'] !== '0000-00-00' && $class['endDate'] < $period['startDate']) { $displayPeriod = false; }?>
	<?php if($class['startClassDate'] !== '0000-00-00' && $class['startClassDate'] >= $period['endDate']) { $displayPeriod = false; }?>
	<?php if($class['endClassDate'] !== '0000-00-00' && $class['endClassDate'] < $period['startDate']) { $displayPeriod = false; }?>
<?php
		if(!isset($class_periods[$period['id']])){
			$class_periods[$period['id']] = array();
		}
		$class_periods[$period['id']][] = $period['need_amount'];
		
		if(!isset($class_period_mustertotals[$period['id']])){
			$class_period_mustertotals[$period['id']] = array();
		}
		$class_period_mustertotals[$period['id']][] = isset($period['total'])?$period['total']: '0';
		
		if(!isset($class_period_discounts[$period['id']])){
			$class_period_discounts[$period['id']] = array();
		}
		$class_period_discounts[$period['id']][] = $period['discount_amount'];
	?>
	<?php if(!$displayPeriod) { echo '<!--';} ?>
		<div title="{period[name]}" >
			<?php $dates = $data->getStudyDates($class['id']); ?>
			<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
			<tr>
				{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
					<?php if ($class['startClassDate'] == '0000-00-00' || $class['startClassDate'] <= $date['studyDate']) { ?>
					<?php if ($class['endClassDate'] == '0000-00-00' || $class['endClassDate'] > $date['studyDate']) { ?>
					<th>{? echo date('d/m', strtotime($date['studyDate']))?}</th>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
				{/each}
			</tr>
			<tr>
				{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
					<?php if ($class['startClassDate'] == '0000-00-00' || $class['startClassDate'] <= $date['studyDate']) { ?>
					<?php if ($class['endClassDate'] == '0000-00-00' || $class['endClassDate'] > $date['studyDate']) { ?>
					<td><select class="muster_{class[id]}_{date[studyDate]}" id="muster_{class[id]}_{student[id]}_{date[studyDate]}" name="muster[{class[id]}][{student[id]}][{date[studyDate]}]"
							onchange="submitMuster('{class[id]}', '{student[id]}', '{date[studyDate]}', this.value)">
						<option value="0">N/A</option>
						<option value="1">CM</option>
						<option value="2">NTT</option>
						<option value="3">NKT</option>
						<option value="4">KTT</option>
						<option value="5">DH</option>
					</select>
					</td>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					{/each}
			</tr>
			</table>
			<div class="left-column">
				<div class="left-handside">Điểm danh: </div><div class="right-handside">{period[total]}</div><div class="clear"></div>
				<div class="left-handside">Số buổi học:</div><div class="right-handside">{period[1]}</div><div class="clear"></div>
				<div class="left-handside">Nghỉ trừ tiền:</div><div class="right-handside">{period[2]}</div><div class="clear"></div>
				<div class="left-handside">Nghỉ K.trừ tiền:</div><div class="right-handside">{period[3]}</div><div class="clear"></div>
				<div class="left-handside">Lý do:</div><div class="right-handside">
				
				<?php if(isset($period['last_period'])) { 
					$last_period = $period['last_period'];
					$period['reason'] = @$period['reason'] ." ". @$last_period['later_reason'];
				} ?>
				{period[reason]}
				<?php 
				if(!isset($class_discount_reasons[$period['id']])){
					$class_discount_reasons[$period['id']] = array();
				}
				$class_discount_reasons[$period['id']][] = @$period['reason'];
				?>
				</div><div class="clear"></div>
			</div>
			<div class="right-column">
				<div class="left-handside">Học phí:</div><div class="right-handside">{? echo product_price($period['amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Trừ sang tháng sau:</div><div class="right-handside">{? echo product_price($period['next_discount_amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Lý do:</div><div class="right-handside">{period[later_reason]}</div><div class="clear"></div>
				<div class="left-handside">Trừ từ tháng trước:</div><div class="right-handside">{? echo product_price($period['discount_amount']) ?}</div><div class="clear"></div>
				<div class="left-handside">Phải đóng:</div><div class="right-handside">{? echo product_price($period['need_amount']) ?}</div><div class="clear"></div>
				<?php if(isset($period['orderId'])) { 
				$order = _db()->select('orderId')->from('student_order')->where('id=' . $period['orderId'])->result_one();
				?>
				<div class="left-handside"><a href="<?php echo BASE_URL; ?>/index.php/order/detail?id={order[orderId]}" target="_blank">Xem hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
				<?php } else { ?>
				<div class="left-handside"><a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&classIds={class[id]}&studentId={student[id]}&periodId={period[id]}&amounts={period[need_amount]}&discounts={period[discount_amount]}&musters={period[total]}&discount_reasons={period[reason]}&prices={class[amount]}" target="_blank">Tạo hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
	<?php if(!$displayPeriod) { echo '-->';} ?>
	<?php } ?>
<?php 
$statuses = $data->getStatuses($class['id'], $student['id']);
?>
		<script type="text/javascript">
var statuses = <?php echo json_encode($statuses)?>;
$(document).ready(function(e) {
	for(var i=0; i < statuses.length; i++) {
		var classId = statuses[i]['classId'];
		var studentId = statuses[i]['studentId'];
		var studyDate = statuses[i]['studyDate'];
		var status = statuses[i]['status'];
		$('#muster_' + classId + '_' + studentId + '_' + studyDate).val(status);
	}
});
</script>
	</div>
	
</div>
<?php } ?>
<div title="Hóa đơn tổng">
	<h2>Hóa đơn tổng</h2>
	<div style="width:578px;height:auto;">
	<?php 
	if(isset($class) && $class)
	foreach($class['periods'] as $period) { ?>
		<div title="{period[name]}">
			<h3>{period[name]}</h3>
			<div class="left-handside">
			<?php $all_amounts = @$class_periods[$period['id']];
			$total_amounts = 0;
			if(!$all_amounts) $all_amounts = array();
			foreach($all_amounts as $each_amount) {
				$total_amounts += $each_amount;
			}
			
			?>
			Tổng cộng: <?php echo product_price($total_amounts);?> &nbsp;
<a href="<?php echo BASE_URL; ?>/index.php/order/create?multiple=1&prices={? echo @implode(',', @$classPrices) ?}&classIds={? echo @implode(',', @$classIds) ?}&studentId={student[id]}&periodId={period[id]}&discounts={? echo @implode(',', @$class_period_discounts[$period['id']]) ?}&musters={? echo @implode(',', @$class_period_mustertotals[$period['id']]) ?}&amounts={? echo @implode(',', @$class_periods[$period['id']]) ?}&discount_reasons={? echo @implode(',', @$class_discount_reasons[$period['id']]) ?}" target="_blank">Tạo hóa đơn</a></div><div class="right-handside"></div><div class="clear"></div>
		</div>
	<?php } ?>
	</div>
</div>
</div>
</div>
<style type="text/css">
	.left-column, .right-column {
		float: left;
		width: 49%;
	}
	.left-column {
		border-right: 1px solid black;
	}
	.right-column {
		margin-left:5px;
	}
	.left-handside, .right-handside{
		float: left;
	}
	.left-handside {
		width: 100px;
		float: left;
	}
	.right-handside {
		width: 190px;
	}
</style>
<script type="text/javascript">
	$('#student_detail_div .easyui-tabs').tabs();
	$('#student_detail_div .easyui-accordion').accordion();
	function submitMuster(classId, studentId, studyDate, status) {
		$.ajax({
			type: 'post',
			method: 'post',
			url: BASE_URL + '/index.php/Dtable/replace?table=student_schedule',
			data: {classId: classId, studentId: studentId, studyDate: studyDate, status: status},
			success: function(result) {
				var result = eval('('+result+')');
				if (result.errorMsg){
					$.messager.show({
						title: 'Error',
						msg: result.errorMsg
					});
				}
			}
		});
	}
</script>
<?php
$student = $data->getStudent();
$period = $data->getPeriod();
if(!$data->multiple) {
	$class = $data->getClass();
	if($class['subjectId'])
		$subject = _db()->select('*')->from('subject')->where('id='. $class['subjectId'])->result_one();
	$amount = $data->amount;
	$reason = 'Nộp tiền lớp ' . $class['name'] . ' môn ' . $subject['name'];
} else {
	$reason = 'Nộp tiền ';
	$classes = $data->getClass();
	foreach($classes as $index => &$class) {
		if($class['subjectId']) {
			$subject = _db()->select('*')->from('subject')->where('id='. $class['subjectId'])->result_one();
			$classes[$index]['subject'] = $subject;
		}
		if($period) {
			$periodId = $period['id'];
		} else {
			$periodId = 0;
		}
		$reason .= 'lớp ' . $class['name'] . ' môn ' . $subject['name'] . ', ';
		$tuition_fee = _db()->useCB()->select('*')->from('tuition_fee')->where(array('and', array('classId', $class['id']), array('periodId', $periodId)))->result_one();
		if($tuition_fee) {
			$class['amount'] = $tuition_fee['amount'];
		}
	}
	$reason .= $period['name'];
	$amounts = explode(',', $data->amounts);
	$musters = explode(',', $data->musters);
	$discounts = explode(',', $data->discounts);
	$discount_reasons = explode(',', $data->discount_reasons);
	$amount = 0;
	foreach($amounts as $a) {
		$amount += $a;
	}
}
?>
<form action="<?php echo BASE_URL; ?>/index.php/order/post" method="post">
<input type="hidden" name="multiple" value="{prop multiple}" />
<?php if($data->multiple == false) { ?>
<input type="hidden" name="classIds" value="{prop classId}" />
<input type="hidden" name="amounts" value="{prop amount}" />
<?php } else { ?>
<input type="hidden" name="classIds" value="{prop classIds}" />
<input type="hidden" name="amounts" value="{prop amounts}" />
<input type="hidden" name="musters" value="{prop musters}" />
<input type="hidden" name="discounts" value="{prop discounts}" />
<input type="hidden" name="discount_reasons" value="{prop discount_reasons}" />
<input type="hidden" name="prices" value="{prop prices}" />
<?php } ?>
<input type="hidden" name="studentId" value="{prop studentId}" />
<input type="hidden" name="payment_periodId" value="{prop periodId}" />
<div class="order_wrapper">
	<div class="order_header">
		<div class="order_company">
			<div class="order_line">
				<span class="order_line_label">Đơn vị: </span>
				<span class="order_line_value">CÔNG TY CP NEXT NOBELS</span>
			</div>
			<div class="order_line">
				<span class="order_line_label">Địa chỉ: </span>
				<span class="order_line_value">Số 6 ngõ 115 Nguyễn Khang - Cầu Giấy - Hà Nội</span>
			</div>
		</div>
		<div class="order_date">
			<div class="order_line">
				<strong class="order_line_label order_line_label_header">Phiếu Thu</strong><br />
				<span class="order_line_value">Ngày <input class="easyui-datebox" type="text" name="created" value="{? echo date('m/d/Y', time()); ?}" /></span>
			</div>
		</div>
		<div class="order_no">
		Quyển số:<input style="width: 110px;" disabled="disabled" class="easyui-numberbox" type="text" name="bookNum" /><br />
		Số:<input class="easyui-numberbox" disabled="disabled" type="text" name="noNum"/><br />
		Nợ:<input class="easyui-numberbox" type="text" name="debit" /><br />
		Có:<input class="easyui-numberbox" type="text" name="balance" />
		</div>
		<div class="order_template">
			Mẫu số 01-TT<br />
			QĐ số: 1141-TC/QĐ/CĐKT<br />
			Ngày 1 tháng 11 năm 1995 của Bộ Tài Chính
		</div>
		<div class="clear"></div>
	</div>
	<div class="order_body">
		<div class="order_line">
			<span class="order_line_label">Họ, tên người nộp tiền: </span>
			<span class="order_line_value"><input type="hidden" name="name" value="{student[name]}" />{student[name]}</span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số điện thoại: </span>
			<span class="order_line_value"><input type="hidden" name="phone" value="{student[phone]}" />{student[phone]}</span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Địa chỉ: </span>
			<span class="order_line_value"><input type="hidden" name="address"  value="{student[address]}" />{student[address]}</span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Lý do thu: </span>
			<span class="order_line_value"><input type="hidden" name="reason" value="{reason}" />{reason}</span>
		</div>
		<div class="order_line">
			<table border="1" style="border-collapse: collapse; width: 100%">
				<tr>
					<td><strong>Môn học</strong></td>
					<td><strong>Lớp học</strong></td>
					<td><strong>Số <?php if($period) { ?>buổi<?php } else { ?>khóa<?php } ?></strong></td>
					<td><strong>HP/<?php if($period) { ?>buổi<?php } else { ?>khóa<?php } ?></strong></td>
					<td><strong>Thành tiền</strong></td>
					<td><strong>Trừ T.trước</strong></td>
					<td><strong>Lý do</strong></td>
					<td><strong>Tổng cộng</strong></td>
				</tr>
				<?php if($data->multiple) { ?>
				<?php foreach($classes as $i => $class) { 
				$subject = $class['subject'];
				?>
				<tr>
					<td>{subject[name]}</td>
					<td>{class[name]}</td>
					<td>{? echo $musters[$i] ?}</td>
					<td>{? echo product_price($class['amount']) ?}</td>
					<td>{? echo product_price($musters[$i]*$class['amount']) ?}</td>
					<td>{? echo product_price($discounts[$i]) ?}</td>
					<td>{? echo @$discount_reasons[$i] ?}</td>
					<td>{? echo product_price($amounts[$i]) ?}</td>
				</tr>
				<?php } ?>
				<?php } ?>
			</table>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số tiền: </span>
			<span class="order_line_value"><input type="text" name="amount" value="{amount}" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Kèm theo: </span>
			<span class="order_line_value"><input type="text" name="additional" /></span>
			<span class="order_line_label">Chứng từ kế toán: </span>
			<span class="order_line_value"><input type="text" name="invoiceNum" /></span>
		</div>
	</div>
	
	<div class="order_signature_wrapper">
		<!--div class="order_date">Ngày <input class="easyui-datebox" type="text" name="created" /></div-->
		<div class="order_signature">
			<div class="order_signature_item">
				<strong>Giám đốc</strong><br />
				(Ký, họ tên, đóng dấu)<br />
				<br />
				<br />
				<br />
			</div>
			<div class="order_signature_item">
				<strong>Người nộp tiền</strong><br />
				(Ký, họ tên)
				
			</div>
			<div class="order_signature_item">
				<strong>Thủ quỹ</strong><br />
				(Ký, họ tên)<br />
				<br />
				<br />
				<br />
				Phạm Thị Phương Thu
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="order_footer"></div>
</div>
<div class="form_action">
	<input type="submit" value="Gửi" />
	<a href="<?php echo BASE_URL; ?>/index.php/student/search">Quay lại</a>
</div>
</form>
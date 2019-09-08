<?php
$order = $data->getOrder();
$order_items = _db()->select('*')->from('student_order')->where('orderId='. $order['id'])->result();
?>
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
				<span class="order_line_value">Ngày {? echo date('d/m/Y', strtotime($order['created'])) ?}</span>
			</div>
		</div>
		<div class="order_no">
		Quyển số: {order[bookNum]}<br />
		Số: {order[noNum]}<br />
		Nợ: {order[debit]}<br />
		Có: {order[balance]}
		</div>
		<div class="order_template">
			Mẫu số 01-TT<br />
			QĐ số: 1141-TC/QĐ/CĐKT<br />
			Ngày 1 tháng 11 năm 1995 của Bộ Tài Chính
		</div>
		<div class="clear"></div>
	</div>
	<br />
	<div class="order_body">
		<div class="clearfix">
			<div class="half-col">
				<div class="order_line">
					<span class="order_line_label">Họ, tên người nộp tiền: </span>
					<span class="order_line_value">{order[name]}</span>
				</div>
				<div class="order_line">
					<span class="order_line_label">Số điện thoại: </span>
					<span class="order_line_value">{order[phone]}</span>
				</div>
				<div class="order_line">
					<span class="order_line_label">Địa chỉ: </span>
					<span class="order_line_value">{order[address]}</span>
				</div>
				<div class="order_line">
					<span class="order_line_label">Lý do thu: </span>
					<span class="order_line_value">{order[reason]}</span>
				</div>
			</div>
			<div class="half-col">
				<?php $teacher = _db()->select('*')->from('teacher')->whereId($order['adviceId'])->result_one();?>
				<div class="order_line">
						<span class="order_line_label">Nhân viên tư vấn: </span>
						<span class="order_line_value">{teacher[name]}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">HT Thanh toán: </span>
						<span class="order_line_value">{? echo $order['paymentType'] == 0 ? 'Tiền mặt': ($order['paymentType'] == 1 ? 'Chuyển khoản' : 'Trực tuyến') ?}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">Ghi chú: </span>
						<span class="order_line_value">{order[paymentNote]}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">Ngân hàng: </span>
						<span class="order_line_value">{order[bank]}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">Mã giao dịch: </span>
						<span class="order_line_value">{order[transactionCode]}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">ĐV Vận chuyển: </span>
						<span class="order_line_value">{order[shipper]}</span>
				</div>
				<div class="order_line">
						<span class="order_line_label">Mã vận đơn: </span>
						<span class="order_line_value">{order[shippingCode]}</span>
				</div>
			</div>
		</div>
		<div class="order_line">
			<table border="1" style="border-collapse: collapse; width: 100%">
				<tr>
					<?php if($order['type'] == 'software'):?>
					<td><strong>Phần mềm</strong></td>
					<td><strong>Dịch vụ</strong></td>
					<?php else: ?>
					<td><strong>Môn học</strong></td>
					<td><strong>Lớp học</strong></td>
					<?php endif ?>
					<td><strong>Số <?php if(@$order_items[0]['payment_periodId']) { ?>buổi<?php } else { ?>khóa<?php } ?></strong></td>
					<td><strong>HP/<?php if(@$order_items[0]['payment_periodId']) { ?>buổi<?php } else { ?>khóa<?php } ?></strong></td>
					<td><strong>Thành tiền</strong></td>
					<td><strong>Trừ T.trước</strong></td>
					<td><strong>Lý do</strong></td>
					<td><strong>Tổng cộng</strong></td>
				</tr>
				<?php 
				$first = true;
				foreach($order_items as $order_item) {
					$class = _db()->select('*')->from('classes')->where('id='.$order_item['classId'])->result_one();
					$subject = _db()->select('*')->from('subject')->where('id='.$class['subjectId'])->result_one();
				?>
				<?php if($first && $order_item['gift_amount']):
					$first = false;
					?>
					<tr>
						<th colspan="8" align="left">Quà tặng</th>
					</tr>
				<?php endif;?>
				<tr>
					<td>{subject[name]}</td>
					<td>{class[name]}</td>
					<td>{? echo $order_item['muster'] ?}</td>
					<td>{? echo product_price($order_item['price']) ?}</td>
					<td>{? echo product_price($order_item['total_before_discount']) ?}</td>
					<td>{? echo product_price($order_item['discount']) ?}</td>
					<td>{? echo $order_item['discount_reason'] ?}</td>
					<?php if($order_item['amount']):?>
					<td>{? echo product_price($order_item['amount']) ?}</td>
				<?php else:?>
				<td>{? echo product_price($order_item['gift_amount']) ?}</td>
				<?php endif;?>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số tiền: </span>
			<span class="order_line_value">{? echo product_price($order['amount']); ?}</span>
		</div>
		<?php if($order['gift_amount']):?>
		<div class="order_line">
			<span class="order_line_label">Số tiền quà tặng: </span>
			<span class="order_line_value">{? echo product_price($order['gift_amount']); ?}</span>
		</div>
				<?php endif;?>
		<div class="order_line">
			<span class="order_line_label">Kèm theo: </span>
			<span class="order_line_value">{order[additional]}</span>
			<span class="order_line_label">Chứng từ kế toán: </span>
			<span class="order_line_value">{order[invoiceNum]}</span>
		</div>
	</div>
	<br />
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
{children all}
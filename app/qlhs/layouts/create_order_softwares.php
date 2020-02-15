<?php
$student = $data->getStudent();
$classes = $data->getClasses();
$subjects = $data->getSubjects();
$teachers = $data->getTeachers();
$class = null;
if (!$data->multiple) {
	$class = $data->getClass();
	if ($class['subjectId'])
		$subject = _db()->select('*')->from('subject')->where('id=' . $class['subjectId'])->result_one();
	$amount = @$data->amount;
	$reason = 'Nộp tiền dịch vụ ' . $class['name'] . ' của ' . $subject['name'];
} else {
	$reason = 'Nộp tiền ';
	$classes = $data->getClass();
	foreach ($classes as $index => &$class) {
		if ($class['subjectId']) {
			$subject = _db()->select('*')->from('subject')->where('id=' . $class['subjectId'])->result_one();
			$classes[$index]['subject'] = $subject;
		}
		if ($period) {
			$periodId = $period['id'];
		} else {
			$periodId = 0;
		}
		$reason .= 'lớp ' . $class['name'] . ' môn ' . $subject['name'] . ', ';
		$tuition_fee = _db()->useCB()->select('*')->from('tuition_fee')->where(array('and', array('classId', $class['id']), array('periodId', $periodId)))->result_one();
		if ($tuition_fee) {
			$class['amount'] = $tuition_fee['amount'];
		}
	}
	$reason .= $period['name'];
	$amounts = explode(',', $data->amounts);
	$musters = explode(',', $data->musters);
	$discounts = explode(',', $data->discounts);
	$discount_reasons = explode(',', $data->discount_reasons);
	$amount = 0;
	foreach ($amounts as $a) {
		$amount += $a;
	}
}
?>
<form action="<?php echo BASE_URL; ?>/index.php/order/softwarePost" method="post">
	<input type="hidden" name="multiple" value="{prop multiple}" />
	<?php if ($data->multiple == false) { ?>
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
	<div class="order_wrapper" style="width: 950px; margin: 0 auto;">
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
				Số:<input class="easyui-numberbox" disabled="disabled" type="text" name="noNum" /><br />
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
			<div class="clearfix">
				<div class="half-col">
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
						<span class="order_line_value"><input type="hidden" name="address" value="{student[address]}" />{student[address]}</span>
					</div>
				</div>
				<div class="halft-col">
					<div class="order_line">
						<span class="order_line_label">Nhân viên tư vấn: </span>
						<span class="order_line_value">
							<select name="adviceId">
								{each $teachers as $teacher}
								<option value="{teacher[id]}">{teacher[name]}</option>
								{/each}
							</select>
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">HT thanh toán:</span>
						<span class="order_line_value">
							<select name="paymentType">
								<option value="0">Tiền mặt</option>
								<option value="1">Chuyển Khoản</option>
								<option value="2">Trực tuyến</option>
							</select>
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">Ghi chú:</span>
						<span class="order_line_value">
							<input type="text" name="paymentNote" />
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">Ngân hàng:</span>
						<span class="order_line_value">
							<input type="text" name="bank" />
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">Mã giao dịch:</span>
						<span class="order_line_value">
							<input type="text" name="transactionCode" />
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">ĐV vận chuyển:</span>
						<span class="order_line_value">
							<input type="text" name="shipperId" />
						</span>
					</div>
					<div class="order_line">
						<span class="order_line_label">Mã vận đơn:</span>
						<span class="order_line_value">
							<input type="text" name="shipCode" />
						</span>
					</div>
				</div>
			</div>
			<div class="order_line">&nbsp;</div>
			<div class="order_line">
				<table class="order_item_table" border="1" style="border-collapse: collapse; width: 100%">
					<tr>
						<td><strong>Dịch vụ</strong></td>
						<td><strong>Phần mềm</strong></td>
						<td><strong>Học phí</strong></td>
						<td><strong>Số lượng</strong></td>
						<td><strong>Đơn vị</strong></td>
						<td><strong>Thành tiền</strong></td>
						<td><strong>Giảm giá</strong></td>
						<td><strong>Lý do</strong></td>
						<td><strong>Tổng tiền</strong></td>
						<td><strong>[+] [-]</strong></td>
					</tr>
					<tr class="order_item_row">
						<td>
							<select name="items_classId[]" class="order_item_classId">
								{each $classes as $cl}
								<option value="{cl[id]}" <?php if ($cl['id'] == $class['id']) : ?>selected="selected" <?php endif; ?>>{cl[name]}</option>
								{/each}
							</select>
						</td>
						<td>
							<select name="items_subjectId[]" class="order_item_subjectId">
								{each $subjects as $sbj}
								<option value="{sbj[id]}" <?php if ($sbj['id'] == $subject['id']) : ?>selected="selected" <?php endif; ?>>{sbj[name]}</option>
								{/each}
							</select>
						</td>
						<td><input class="order_item_price" name="items_price[]" value="{class[amount]}" size="7" onkeyup="calculateTotal()" /></td>
						<td><input class="order_item_quantity" name="items_quantity[]" value="1" size="2" onkeyup="calculateTotal()" /></td>
						<td><select class="order_item_unit" name="items_unit[]">
								<option value="nam">Năm</option>
								<option value="thang">Tháng</option>
								<option value="quyen">Quyển</option>
							</select></td>
						<td><input class="order_item_amount_before_discount" name="items_amount_before_discount[]" value="{class[amount]}" size="7" /></td>
						<td><input class="order_item_discount" name="items_discount[]" size="7" value="0" onkeyup="calculateTotal()" /></td>
						<td><input class="order_item_discount_reason" name="items_discount_reason[]" size="17" /></td>
						<td><input class="order_item_amount" name="items_amount[]" size="7" /></td>
						<td><a href="#" onclick="addItem(this); return false;">[+]</a> <a href="#" onclick="removeItem(this); return false;">[-]</a></td>
					</tr>
				</table>
			</div>
			<div class="order_line">
				<span class="order_line_label">Số tiền: </span>
				<span class="order_line_value"><input class="order_total_amount" type="text" name="amount" value="{amount}" /></span>
			</div>
			<div class="order_line">
				<h2>Quà tặng</h2>
			</div>
			<div class="order_line">
				<table class="gift_item_table" border="1" style="border-collapse: collapse; width: 100%">
					<tr>
						<td><strong>Dịch vụ</strong></td>
						<td><strong>Phần mềm</strong></td>
						<td><strong>Học phí</strong></td>
						<td><strong>Số lượng</strong></td>
						<td><strong>Đơn vị</strong></td>
						<td><strong>Thành tiền</strong></td>
						<td><strong>[+] [-]</strong></td>
					</tr>
					<tr class="gift_item_row">
						<td>
							<select name="gifts_classId[]" class="gift_item_classId">
								<option value="" selected="selected">Chọn</option>
								{each $classes as $cl}
								<option value="{cl[id]}">{cl[name]}</option>
								{/each}
							</select>
						</td>
						<td>
							<select name="gifts_subjectId[]" class="gift_item_subjectId">
								<option value="" selected="selected">Chọn</option>
								{each $subjects as $sbj}
								<option value="{sbj[id]}">{sbj[name]}</option>
								{/each}
							</select>
						</td>
						<td><input class="gift_item_price" name="gifts_price[]" value="0" size="7" onkeyup="calculateGiftTotal()" /></td>
						<td><input class="gift_item_quantity" name="gifts_quantity[]" value="1" size="2" onkeyup="calculateTotal()" /></td>
						<td><select class="gift_item_unit" name="gifts_unit[]">
								<option value="nam">Năm</option>
								<option value="thang">Tháng</option>
								<option value="quyen">Quyển</option>
							</select></td>
						<td><input class="gift_item_amount" name="gifts_amount[]" value="0" size="7" /></td>
						<td><a href="#" onclick="addGiftItem(this); return false;">[+]</a> <a href="#" onclick="removeGiftItem(this); return false;">[-]</a></td>
					</tr>
				</table>
			</div>
			<div class="order_line">
				<span class="order_line_label">Số tiền quà tặng: </span>
				<span class="order_line_value"><input class="gift_total_amount" type="text" name="gift_amount" value="" /></span>
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
	<div class="form_action" style="text-align: center">
		<input type="submit" value="Gửi" />
		<a href="<?php echo BASE_URL; ?>/index.php/student">Quay lại</a>
	</div>
</form>
<script>
	function addItem(elem) {
		var orderItemTable = jQuery('.order_item_table');
		var orderItemCurrent = jQuery(elem).parents('.order_item_row');
		orderItemTable.append(orderItemCurrent.clone());
		calculateTotal();
	}

	function removeItem(elem) {
		var orderItemTable = jQuery('.order_item_table');
		var orderItemCurrent = jQuery(elem).parents('.order_item_row');
		if (orderItemTable.find('.order_item_row').length > 1) {
			orderItemCurrent.remove();
		} else {
			jQuery.messager.alert('Thông báo', 'Không thể xóa bản ghi này');
		}
		calculateTotal();
	}

	function calculateTotal() {
		var orderItemTable = jQuery('.order_item_table');
		var orderItemRows = orderItemTable.find('.order_item_row');
		var total_amount = 0;
		orderItemRows.each(function(index, orderItemRow) {
			orderItemRow = jQuery(orderItemRow);
			var classId = orderItemRow.find('.order_item_classId').val();
			var subjectId = orderItemRow.find('.order_item_subjectId').val();
			var price = orderItemRow.find('.order_item_price').val();
			var quantity = orderItemRow.find('.order_item_quantity').val();
			var discount = orderItemRow.find('.order_item_discount').val();
			var amount_before_discount = orderItemRow.find('.order_item_amount_before_discount');
			var amount = orderItemRow.find('.order_item_amount');
			var item_amount_before_discount = parseFloat(price) * parseFloat(quantity);
			amount_before_discount.val(item_amount_before_discount);
			var item_amount = 0;
			if(parseFloat(discount) < 100) {
				item_amount = item_amount_before_discount - parseFloat(discount) / 100 * item_amount_before_discount;
			} else {
				item_amount = item_amount_before_discount - parseFloat(discount);
			}
			
			total_amount += item_amount;
			amount.val(item_amount);
		});
		jQuery('.order_total_amount').val(total_amount);

	}

	function addGiftItem(elem) {
		var orderItemTable = jQuery('.gift_item_table');
		var orderItemCurrent = jQuery(elem).parents('.gift_item_row');
		orderItemTable.append(orderItemCurrent.clone());
		calculateGiftTotal();
	}

	function removeGiftItem(elem) {
		var orderItemTable = jQuery('.gift_item_table');
		var orderItemCurrent = jQuery(elem).parents('.gift_item_row');
		if (orderItemTable.find('.gift_item_row').length > 1) {
			orderItemCurrent.remove();
		} else {
			jQuery.messager.alert('Thông báo', 'Không thể xóa bản ghi này');
		}
		calculateGiftTotal();
	}

	function calculateGiftTotal() {
		var orderItemTable = jQuery('.gift_item_table');
		var orderItemRows = orderItemTable.find('.gift_item_row');
		var total_amount = 0;
		orderItemRows.each(function(index, orderItemRow) {
			orderItemRow = jQuery(orderItemRow);
			var classId = orderItemRow.find('.gift_item_classId').val();
			var subjectId = orderItemRow.find('.gift_item_subjectId').val();
			var price = orderItemRow.find('.gift_item_price').val();
			var quantity = orderItemRow.find('.gift_item_quantity').val();
			var amount = orderItemRow.find('.gift_item_amount');
			var item_amount = parseFloat(price) * parseFloat(quantity);
			amount.val(item_amount);
			total_amount += item_amount;
			jQuery('.gift_total_amount').val(total_amount);
		});

	}
	setTimeout(function(){
		calculateTotal();
		calculateGiftTotal();
	}, 100);
	var subjects = <?php echo json_encode($subjects); ?>;
	var classes = <?php echo json_encode($classes); ?>;
</script>
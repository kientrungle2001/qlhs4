<form method="post" action="{url /partner/create_billing_multiple_post}">
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
				<strong class="order_line_label order_line_label_header">Phiếu Chi</strong><br />
				<span class="order_line_value">Ngày <input class="easyui-datebox" type="text" name="created" /></span>
			</div>
		</div>
		<div class="order_no">
		Quyển số: <input style="width: 110px;" class="easyui-numberbox" type="text" name="bookNum" disabled="disabled" /><br />
		Số: <input class="easyui-numberbox" type="text" name="noNum" disabled="disabled"/><br />
		Nợ: <input class="easyui-numberbox" type="text" name="debit" /><br />
		Có: <input class="easyui-numberbox" type="text" name="balance" />
		</div>
		<div class="order_template">
			Mẫu số: C31-BB<br />
			QĐ số: 19/2006/QĐ-BTC<br />
			ngày 30/3/2006 của Bộ trưởng Bộ Tài chính
		</div>
		<div class="clear"></div>
	</div>
	<br />
	<div class="order_body">
		<input type="hidden" name="partyType" value="partner" />
		<input type="hidden" name="partnerId" value="" />
		<div class="order_line">
			<span class="order_line_label">Họ, tên người nhận tiền: </span>
			<span class="order_line_value"><input type="text" name="order_name" value="" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Địa chỉ: </span>
			<span class="order_line_value"><input type="text" name="address" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số điện thoại: </span>
			<span class="order_line_value"><input type="text" name="phone" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Lý do nộp: </span>
			<span class="order_line_value"><input type="text" name="reason" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_value">
			<table id="order_items_table" border="1" style="border-collapse: collapse; width: 100%">
				<tr>
					<td><strong>Mục</strong></td>
					<td><strong>Giá</strong></td>
					<td><strong>Số lượng</strong></td>
					<td><strong>Thành tiền</strong></td>
					<td><strong>Giảm giá</strong></td>
					<td><strong>Tổng cộng</strong></td>
					<td><strong>Xóa</strong></td>
				</tr>
				<tr class="order_item_row">
					<td><input class="item_input_name" name="name[]" /></td>
					<td><input onchange="calculateOrder();" class="item_input item_input_price" name="price[]" /></td>
					<td><input onchange="calculateOrder();" class="item_input item_input_quantity" name="quantity[]" value="1" /></td>
					<td>
						<span class="item_input_total_before_discount"></span>
						<input class="item_input_total_before_discount_hidden" type="hidden" name="total_before_discount[]">
					</td>
					<td><input onchange="calculateOrder();" class="item_input item_input_discount" name="discount[]" value="0"/></td>
					<td>
						<span class="item_input_amount"></span>
						<input class="item_input_amount_hidden" type="hidden" name="amount[]">
					</td>
					<td><a href="javascript:void(0);" onclick="if($('#order_items_table tr').length <= 3){alert('Không thể xóa dòng này');} else{ $(this).parent().parent().remove(); calculateOrder();} return false;">Xóa</a></td>
				</tr>
				<tr class="last">
					<td colspan="7"><button onclick="clone_last_item(); return false;">Thêm</button></td>
				</tr>
			</table>
			</span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số tiền: </span>
			<span class="order_line_value"><input type="text" name="total_amount" class="input_total_amount" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Kèm theo: </span>
			<span class="order_line_value"><input type="text" name="additional" /></span>
			<span class="order_line_label">Chứng từ kế toán: </span>
			<span class="order_line_value"><input type="text" name="invoiceNum" /></span>
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
				<strong>Người nhận tiền</strong><br />
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
<input type="submit" value="Gửi" />
</form>
{children all}
<script type="text/javascript">
function calculateOrder() {
	var $rows = $('#order_items_table .order_item_row');
	var total_amount = 0;
	$.each($rows, function(index, tr) {
		var $tr = $(tr);
		var price = parseFloat($tr.find('.item_input_price').val());
		var discount = parseFloat($tr.find('.item_input_discount').val());
		var quantity = parseInt($tr.find('.item_input_quantity').val());
		var total = price * quantity;
		var amount = total - discount;
		$tr.find('.item_input_total_before_discount').text(total);
		$tr.find('.item_input_total_before_discount_hidden').val(total);
		$tr.find('.item_input_amount').text(amount);
		$tr.find('.item_input_amount_hidden').val(amount);
		total_amount += amount;
	});
	$('.input_total_amount').val(total_amount);
}
setTimeout(
	function() {
		jQuery('.order_wrapper [name=order_name]').pzkAutoComplete({
			loader: function(word, callback) {
				pzks.dtable.partner.search(word, function(resp){
					return callback(resp.rows);
				});
			},
			matcher: function(item, word) {
				return true;
			},
			renderValue: function(item) {
				return item.name;
			},
			renderLabel: function(item) {
				return item.name + ' - ' + item.phone + ' - ' + item.code;
			},
			onSelect: function(item) {
				$('.order_wrapper [name=partnerId]').val(item.id);
				$('.order_wrapper [name=phone]').val(item.phone);
				$('.order_wrapper [name=address]').val(item.address);
			}
		});
	}, 1000);
	function clone_last_item() {
		var last_item_clone = $('#order_items_table tr:eq(1)').clone();
		last_item_clone.find('.pzk-autocomplete').remove();
		$('#order_items_table .last').before(last_item_clone); 
		calculateOrder();
	}

</script>
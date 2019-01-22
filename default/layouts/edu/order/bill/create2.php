<form method="post" action="{url /order/createbillpost2}">
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
				<span class="order_line_value">Ngày <input class="easyui-datebox" type="text" name="created" value="{? echo date('m/d/Y', time()); ?}"/></span>
			</div>
		</div>
		<div class="order_no">
		Quyển số: <input style="width: 110px;" class="easyui-numberbox" type="text" name="bookNum" disabled="disabled" /><br />
		Số: <input class="easyui-numberbox" type="text" name="noNum" disabled="disabled"/><br />
		Nợ: <input class="easyui-numberbox" type="text" name="debit" /><br />
		Có: <input class="easyui-numberbox" type="text" name="balance" />
		</div>
		<div class="order_template">
			Mẫu số: 02-TT<br />
			QĐ số: 15/2006/QĐ-BTC<br />
			ngày 20/3/2006 của Bộ trưởng BTC
		</div>
		<div class="clear"></div>
	</div>
	<br />
	<div class="order_body">
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
			<span class="order_line_label">Lý do chi: </span>
			<span class="order_line_value"><input type="text" name="reason"  style="width: 300px" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Số tiền: </span>
			<span class="order_line_value"><input type="text" name="total_amount" class="input_total_amount" /></span>
			<span class="order_line_label">(Viết bằng chữ) </span>
			<span class="order_line_value"><input type="text" name="total_amount_string" class="input_total_amount_string" style="width: 300px" /></span>
		</div>
		<div class="order_line">
			<span class="order_line_label">Kèm theo: </span>
			<span class="order_line_value"><input type="text" name="additional" /></span>
			<span class="order_line_label">Chứng từ gốc: </span>
			<span class="order_line_value"><input type="text" name="invoiceNum" /></span>
			<span class="order_line_label">Đã nhận đủ số tiền (viết bằng chữ): </span>
			<span class="order_line_value"><input type="text" name="confirm" style="width: 300px" /></span>
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
	<div class="order_footer">
	<p>Đã nhận đủ số tiền (viết bằng chữ): .........................................................................</p>
	<p>+ Tỉ giá ngoại tệ(vàng, bạc, đá quý): .......................................................................</p>
	<p>+ Số tiền quy đổi: ..........................................................................................</p>
	</div>
</div>
<input type="submit" value="Gửi" />
</form>
{children all}
<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div id="report">
	<frm.form gridId="dg" action="{url /order/reportPost}">
		<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu">
			</frm.formItem>
		<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc">
			</frm.formItem>
		<frm.formItem type="user-defined" name="subjectId" label="Môn học">
		<form.selectbox label="Môn học" name="subjectId" id="subjectId"
			sql="{subject_sql}"
				></form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="payment_type" required="false" label="Hình thức thanh toán">
				<form.selectbox name="payment_type" id="payment_type">
				<option value="">Tất cả</option>
					<option value="0">Tiền mặt</option>
					<option value="1">Chuyển khoản</option>
				</form.selectbox>
		</frm.formItem>
		<frm.formItem name="assignId" label="Người phụ trách" type="user-defined">
				<form.selectbox label="Người phụ trách" name="assignId" id="assignId"
			sql="{teacher_sql}"
				></form.selectbox>
			</frm.formItem>
		<frm.formItem type="user-defined" name="send" required="false" label="">
			<input type="submit" value="Xem báo cáo" />
		</frm.formItem>
	</frm.form>
	<script>
	setTimeout(function(){
		jQuery('#payment_type').pzkVal('<?php echo @$_REQUEST['payment_type']?>');
		jQuery('#assignId').pzkVal('<?php echo @$_REQUEST['assignId']?>');
	}, 100);
		
	</script>
</div>
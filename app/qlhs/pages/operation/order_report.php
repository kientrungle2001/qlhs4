<div id="report">
	<frm.form gridId="dg" action="{url /order/reportPost}">
		<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu">
			</frm.formItem>
		<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc">
			</frm.formItem>
		<frm.formItem type="text" name="subject" label="Môn học">
			</frm.formItem>
		<frm.formItem type="text" name="notsubject" label="Không phải Môn học">
			</frm.formItem>
		<frm.formItem type="user-defined" name="send" required="false" label="">
			<input type="submit" value="Xem báo cáo" />
		</frm.formItem>
	</frm.form>
</div>
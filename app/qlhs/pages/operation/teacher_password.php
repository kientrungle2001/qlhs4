<frm.form id="changePasswordForm" title="" action="{url /teacher/changePasswordPost}">
	<frm.formItem name="oldPassword" required="true" validatebox="true" label="Mật khẩu cũ" />
	<frm.formItem name="password" type="password" required="true" validatebox="true" label="Mật khẩu mới" />
	<frm.formItem name="confirmPassword" type="password" required="true" validatebox="true" label="Nhập lại mật khẩu" />
	<frm.formItem type="submit" value="Đổi mật khẩu" />
	<frm.formItem type="button" value="Trở lại" onclick="window.location='{url /teacher/info}'" />
</frm.form>
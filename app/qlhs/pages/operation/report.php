<div>
	<frm.form gridId="dg" action="{url /demo/reportPost}">
		<frm.formItem type="user-defined" label="Loại báo cáo">
			<form.combobox name="reportType"
					sql="select code as value, 
							name as label from `report_type` where 1 order by name ASC"
						layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem type="user-defined" label="Môn học">
			<form.combobox name="subjectId"
					sql="select id as value, 
							name as label from `subject` where 1 order by name ASC"
						layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem type="user-defined" label="Lớp">
			<form.combobox name="classId"
					sql="select id as value, 
							name as label from `classes` where status=1 order by name ASC"
						layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem type="user-defined" label="Giáo viên">
			<form.combobox name="teacherId"
					sql="select id as value, 
							name as label from `teacher` where 1 order by name ASC"
						layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem type="user-defined" label="Kỳ thanh toán">
			<form.combobox name="periodId"
					sql="select id as value, 
							name as label from `payment_period` where 1 order by id desc"
						layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem type="password" label="Mật khẩu" name="password" />
		<frm.formItem type="user-defined" name="send" required="false" label="">
			<input type="submit" value="Xem báo cáo" />
		</frm.formItem>
	</frm.form>
</div>
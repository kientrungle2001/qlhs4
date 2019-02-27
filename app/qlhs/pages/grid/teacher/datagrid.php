<div>
<dg.dataGrid id="dg" title="Quản lý giáo viên" table="teacher"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="150" formatter="teacherInfo">Tên giáo viên</dg.dataGridItem>
	<!--
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="100">Số điện thoại</dg.dataGridItem>
	-->
	<dg.dataGridItem field="subjectName" width="90" formatter="teachingInfo">Môn học</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row){
			$dg_classes.filters({teacherId: row.id});
			$dg_student.filters({teacherIds: row.id});
			$dg_test_class.filters({teacherId: row.id});
			$dg_test_student_mark.filters({teacherId: row.id});
			$dg_student_order.filters({teacherId: row.id});
			$dg_schedule.filters({teacherId: row.id});
			showCalendar();
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Giáo viên">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="type" label="Vai trò">
				<form.selectbox name="type" label="Vai trò">
					<option value="0">Giảng viên</option>
					<option value="1">Trợ giảng</option>
					<option value="2">Nhân viên</option>
					<option value="3">Đối tác</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="name" required="true" validatebox="true" label="Tên giáo viên" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem name="phone" required="false" label="Số điện thoại" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.selectbox name="subjectId"
						sql="{subject_center_sql}" />
			</frm.formItem>
			<frm.formItem type="user-defined" name="departmentId" required="false" label="Phòng ban">
				<form.selectbox name="departmentId"
						sql="{department_sql}" />
			</frm.formItem>
			<frm.formItem name="password" required="false" label="Password" />
			<frm.formItem name="school" required="false" label="Trường" />
			<frm.formItem name="address" required="false" label="Địa chỉ" />
			<frm.formItem name="salary" required="false" label="Lương" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<script>
function teacherInfo(value, item, index) {
	return [item.name, item.code, item.phone].join('<br />');
}
function teachingInfo(value, item, index) {
	return [item.subjectName, item.departmentName].join('<br />');
}
</script>
</div>
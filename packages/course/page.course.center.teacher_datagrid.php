<dg.dataGrid id="dg_class_teacher" title="Danh sách giáo viên" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="50"
		table="class_teacher" width="550px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="140">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="140">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="note" width="140">Ghi chú</dg.dataGridItem>
	<layout.toolbar id="dg_class_teacher_toolbar">
		<layout.toolbarItem action="$dg_class_teacher.add({classId: $dg.getSelected('id')})" icon="add" />
		<layout.toolbarItem action="$dg_class_teacher.edit()" icon="edit" />
		<layout.toolbarItem action="$dg_class_teacher.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_class_teacher" width="700px" height="auto" title="Giáo viên">
		<frm.form gridId="dg_class_teacher">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="classId" required="false" label="Lớp">
				<form.combobox name="classId"
						sql="{class_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="teacherId" required="false" label="Giáo viên">
				<form.combobox name="teacherId"
						sql="{teacher_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="role" required="false" label="Vai trò">
				<select name="role">
					<option value="0">Giáo viên</option>
					<option value="1">Trợ giảng</option>
				</select>
			</frm.formItem>
			<frm.formItem name="note" required="false" label="Ghi chú" />
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
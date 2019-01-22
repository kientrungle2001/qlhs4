<dg.dataGrid id="dg_test_class" title="Danh sách bài thi" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="50"
		table="test_class" width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="testName" width="120">Bài thi</dg.dataGridItem>
	<layout.toolbar id="dg_test_class_toolbar">
		<layout.toolbarItem action="$dg_test_class.add({classId: $dg.getSelected('id')})" icon="add" />
		<layout.toolbarItem action="$dg_test_class.edit()" icon="edit" />
		<layout.toolbarItem action="$dg_test_class.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_test_class" width="700px" height="auto" title="Bài thi">
		<frm.form gridId="dg_test_class">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="classId" required="false" label="Lớp">
				<form.combobox name="classId"
						sql="{class_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="testId" required="false" label="Bài thi">
				<form.combobox name="testId"
						sql="{test_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="startDate" type="date" required="false" validatebox="false" label="Ngày bắt đầu" />
			<frm.formItem name="endDate" type="date" required="false" validatebox="false" label="Ngày kết thúc" />
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
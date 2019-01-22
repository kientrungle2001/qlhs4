<dg.dataGrid id="dg" title="Phân công giảng dạy" table="teaching" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="level" width="80">Lớp</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Giảng dạy">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem 
				type="user-defined"
				name="subjectId" required="true" validatebox="true" label="Môn học">
					<form.combobox name="subjectId"
						sql="select id as value, 
								name as label from `subject` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem 
				type="user-defined"
				name="teacherId" required="true" validatebox="true" label="Giáo viên">
					<form.combobox name="teacherId"
						sql="select id as value, 
								name as label from `teacher` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="level" required="true" validatebox="true" label="Lớp" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
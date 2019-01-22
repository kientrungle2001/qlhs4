<dg.dataGrid id="dg" title="Quản lý phần mềm" table="subject" width="800px" height="450px" defaultFilters='{"online": 1}'>
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày ra mắt</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Phần mềm">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Phần mềm" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem type="hidden" name="online" required="false" label="" />
			<frm.formItem name="startDate" type="date" required="false" validatebox="false" label="Ngày ra mắt" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
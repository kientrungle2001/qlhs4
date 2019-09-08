<dg.dataGrid id="dg" title="Quản lý loại sách" table="subject" rownumbers="false" width="350px" height="450px" defaultFilters='{"online": -1}'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="160">Loại sách</dg.dataGridItem>
	<dg.dataGridItem field="code" width="80">Mã</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row){
			$dg_classes.filters({
				subjectId: row.id
			});
			$dg_student.filters({
				subjectIds: row.id
			});
			$dg_student_order.filters({
				subjectId: row.id
			});
			$dg_advice.filters({
				subjectId: row.id
			});
			$dg_problem.filters({
				subjectId: row.id
			});
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Môn học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="hidden" name="online" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Môn học" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
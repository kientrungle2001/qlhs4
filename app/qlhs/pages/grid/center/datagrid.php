<dg.dataGrid id="dg" title="Quản lý Trung tâm" table="center"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên Trung tâm</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="address" width="120">Địa chỉ</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Kế hoạch">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên kế hoạch" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem name="address" required="true" validatebox="true" label="Địa chỉ" />
			<frm.formItem name="status" label="Trạng thái" />

		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
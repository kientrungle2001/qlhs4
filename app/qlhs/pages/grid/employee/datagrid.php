<dg.dataGrid id="dg" title="Quản lý nhân viên" table="employee"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên nhân viên</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="100">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày vào làm</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày nghỉ làm</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Nhân viên">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên nhân viên" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem name="phone" required="false" label="Số điện thoại" />
			<frm.formItem name="address" required="false" label="Địa chỉ" />
			<frm.formItem type="date" name="startDate" required="false" label="Ngày vào làm" />
			<frm.formItem type="date" name="endDate" required="false" label="Ngày nghỉ làm" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
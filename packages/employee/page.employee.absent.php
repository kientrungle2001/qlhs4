<dg.dataGrid id="dg" title="Quản lý các buổi nghỉ" table="employee_absent"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="1200px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="employeeName" width="120">Tên nhân viên</dg.dataGridItem>
	<dg.dataGridItem field="employeeCode" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<dg.dataGridItem field="total" width="120">Số buổi</dg.dataGridItem>
	<dg.dataGridItem field="reason" width="520">Lý do</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Nhân viên">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="employeeId" label="Nhân viên">
			<form.combobox 
					name="employeeId"
					sql="select id as value, 
							name as label from `employee` order by name ASC"
					layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc" />
			<frm.formItem type="text" name="total" required="false" label="Số buổi nghỉ" />
			<frm.formItem type="text" name="reason" required="false" label="Lý do" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
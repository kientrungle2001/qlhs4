<div>
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
		<hform id="dg_search">
			<form.selectbox id="searchEmployee" name="employeeId" sql="select id as value, 
          name as label from `teacher` order by name ASC" label="Nhân viên" onChange="searchAbsent()"/>
			Ngày bắt đầu: <input type="date" name="startDate" id="searchStartDate" onChange="searchAbsent()" />
			Ngày kết thúc: <input type="date" name="endDate" id="searchEndDate" onChange="searchAbsent()" />
		</hform>
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Nhân viên">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" label="" />
			<frm.formItem type="user-defined" name="employeeId" label="Nhân viên">
				<form.selectbox name="employeeId" sql="select id as value, 
          name as label from `teacher` order by name ASC" label="Nhân viên" />
			</frm.formItem>
			<frm.formItem type="date" name="startDate" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" label="Ngày kết thúc" />
			<frm.formItem type="text" name="total" label="Số buổi nghỉ" />
			<frm.formItem type="text" name="reason" label="Lý do" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<script>
	function searchAbsent() {
		pzk.elements.dg.search({
			fields: {
				employeeId: '#searchEmployee',
				startDate: '#searchStartDate',
				endDate: '#searchEndDate'
			}
		});
	}
</script>
</div>
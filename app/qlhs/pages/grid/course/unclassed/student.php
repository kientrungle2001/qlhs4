<div>
	<dg.dataGrid id="dg_student" title="Danh sách học sinh" scriptable="true" 
			layout="easyui/datagrid/datagrid" 
			nowrap="true" pageSize="10"
			table="student" width="500px" height="450px"
			defaultFilters='{"online": 0}'>
		<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
		<dg.dataGridItem field="name" width="140">Tên học sinh</dg.dataGridItem>
		<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
		<dg.dataGridItem field="note" width="80">Ghi chú</dg.dataGridItem>
		<dg.dataGridItem field="assignName" width="140">Phụ trách</dg.dataGridItem>
	</dg.dataGrid>
</div>
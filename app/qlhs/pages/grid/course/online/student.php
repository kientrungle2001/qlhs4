<div>
<dg.dataGrid id="dg_student" title="Danh sách học sinh" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="10"
		table="student" width="500px" height="450px"
		defaultFilters='{"online": 1}'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="180" formatter="onlineStudentName">Tên học sinh</dg.dataGridItem>
	<dg.dataGridItem field="startStudyDate" width="100">Ngày vào học</dg.dataGridItem>
	<dg.dataGridItem field="assignName" width="140">Phụ trách</dg.dataGridItem>
</dg.dataGrid>
<script>
	function onlineStudentName(value, row, index) {
		return [row.name, row.code, row.phone].join('<br />'); 
	}
</script>
</div>
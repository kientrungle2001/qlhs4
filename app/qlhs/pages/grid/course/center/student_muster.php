<dg.dataGrid id="dg_student_schedule" title="Danh sách điểm danh học sinh" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="50"
		table="student_schedule" width="550px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="140">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="140">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="140">Ngày điểm danh</dg.dataGridItem>
	<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem>
</dg.dataGrid>
<dg.dataGrid id="dg_teacher_schedule" title="Danh sách điểm danh giáo viên" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="10"
		table="teacher_schedule" width="550px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="140">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="140">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="140">Ngày điểm danh</dg.dataGridItem>
	<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem>
</dg.dataGrid>
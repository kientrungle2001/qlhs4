<dg.dataGrid id="dg_schedule" title="Bàn giao tài sản" 
		table="asset_schedule" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên tài sản</dg.dataGridItem>
	<dg.dataGridItem field="softwareName" width="120">Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="price" width="80">Giá trị</dg.dataGridItem>
	<dg.dataGridItem field="quantity" width="80">Số lượng</dg.dataGridItem>
	<dg.dataGridItem field="startStatus" width="80" formatter="asset_status">Trạng thái lúc bàn giao</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80" formatter="asset_status">Trạng thái</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="80">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="80">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="80">Ngày kết thúc</dg.dataGridItem>
</dg.dataGrid>
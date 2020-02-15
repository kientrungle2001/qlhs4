<div>
<dg.dataGrid id="dg_room" title="Quản lý phòng học" table="room" width="650px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên phòng</dg.dataGridItem>
	<dg.dataGridItem field="size" width="80">Cỡ</dg.dataGridItem>
	<dg.dataGridItem field="centerName" width="120">Trung tâm</dg.dataGridItem>
	<dg.dataGridItem field="note" width="180">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80" formatter="room_status">Trạng thái</dg.dataGridItem>
</dg.dataGrid>
<script>
	function room_status(value, item, index) {
		if(value == '-1') {
			return 'Đang sửa';
		}
		if(value == '1') {
			return 'Sẵn có';
		}
		if(value == '0') {
			return 'Không sẵn có';
		}
	}
</script>
</div>
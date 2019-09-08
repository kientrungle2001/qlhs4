<div>
<dg.dataGrid id="dg_advice" title="Tư vấn" scriptable="true" table="test_schedule" width="850px" height="500px"
	rownumbers="false" pageSize="50" defaultFilters='{"type": 1}' nowrap="false"
	rowStyler="adviceRowStyler">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="adviceType" width="120">Loại hình tư vấn</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Dịch vụ</dg.dataGridItem>
	<dg.dataGridItem field="testDate" width="160">Ngày tư vấn</dg.dataGridItem>
	<dg.dataGridItem field="note" width="160">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40" formatter="adviceStatusFormatter">Trạng thái</dg.dataGridItem>
</dg.dataGrid>

<script>
/**
	Format trạng thái lịch hẹn
	 */
	function adviceStatusFormatter(value, row, index) {
		switch (value) {
			case '-2':
				return 'Đang suy nghĩ';
			case '-1':
				return 'Từ chối';
			case '0':
				return 'Chưa gọi';
			case '1':
				return 'Đã gọi';
			case '2':
				return 'Đã dùng thử';
			case '3':
				return 'Đã sử dụng';
		}
	}

	/**
	Format màu sắc bản ghi
	 */
	function adviceRowStyler(index, row) {
		if (row.status == '-1') {
			return 'color: gray; font-weight: normal;';
		}
		if (row.status == '0') {
			return 'color: red; font-weight: normal;';
		}
		if (row.status == '1') {
			return 'color: blue; font-weight: bold;';
		}
		if (row.status == '2') {
			return 'color: green; font-weight: bold;';
		}
		if (row.status == '3') {
			return 'color: black; font-weight: bold;';
		}
		return '';
	}
</script>
</div>
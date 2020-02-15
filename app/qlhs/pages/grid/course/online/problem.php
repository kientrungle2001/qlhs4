<div>
	<dg.dataGrid id="dg_problem" title="Báo lỗi phần mềm" scriptable="true" table="test_schedule" width="500px"
			height="450px" nowrap="false"
			rowStyler="problemRowStyler"
			defaultFilters='{"type": 2}'>
			<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>

			<!--<dg.dataGridItem field="title" width="320">Tiêu đề</dg.dataGridItem>-->
			<dg.dataGridItem field="studentName" width="220" formatter="scheduleStudentFormat">Học sinh
			</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="phone" width="220">Điện thoại</dg.dataGridItem>
			-->
			<dg.dataGridItem field="subjectName" width="220" formatter="adviceSubjectInfo">Phần mềm</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="className" width="120">Gói dịch vụ</dg.dataGridItem>
			-->
			<dg.dataGridItem field="adviceName" width="220" formatter="problemStatusInfo">Tư vấn viên</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="testDate" width="120" formatter="scheduleDateTimeFormat">Ngày Tư vấn</dg.dataGridItem>
			<dg.dataGridItem field="testTime" width="120">Thời gian</dg.dataGridItem>
			<dg.dataGridItem field="status" width="120" formatter="adviceStatusFormatter">Trạng thái</dg.dataGridItem>
			-->

		</dg.dataGrid>
		<script>
			/**
	Format trạng thái lịch hẹn
	 */
	function problemStatusFormatter(value, row, index) {
		switch (value) {
			case '-2':
				return 'Lỗi không sửa được';
			case '-1':
				return 'Lỗi, vấn đề';
			case '0':
				return 'Không có lỗi';
			case '1':
				return 'Đang sửa';
			case '2':
				return 'Đã sửa xong';
		}
	}

	/**
	Format màu sắc bản ghi
	 */
	function problemRowStyler(index, row) {
		if (row.status == '-2') {
			return 'color: gray; font-weight: normal;';
		}
		if (row.status == '-1') {
			return 'color: red; font-weight: normal;';
		}
		if (row.status == '0') {
			return 'color: black; font-weight: normal;';
		}
		if (row.status == '1') {
			return 'color: blue; font-weight: bold;';
		}
		if (row.status == '2') {
			return 'color: green; font-weight: bold;';
		}
		return '';
	}

			function problemStatusInfo(value, item, index) {
				return [item.adviceName, scheduleDateTimeFormat(value, item, index), problemStatusFormatter(item.status)]
					.join('<br />');
			}
		</script>
		</div>
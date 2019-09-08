<div>
	<dg.dataGrid id="dg_advice" title="Tư vấn sử dụng phần mềm" scriptable="true" table="test_schedule" width="500px"
			height="450px" nowrap="false"
			rowStyler="adviceRowStyler"
			defaultFilters='{"type": 1}'>
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
			<dg.dataGridItem field="adviceName" width="220" formatter="adviceStatusInfo">Tư vấn viên</dg.dataGridItem>
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

	function scheduleDateFormat(value, row, index) {
		var tmp = value.split('-');
		return tmp[2] + '/' + tmp[1];
	}

	function scheduleTimeFormat(value, row, index) {
		var tmp = value.split(':');
		return tmp[0] + ':' + tmp[1];
	}

	function scheduleDateTimeFormat(value, row, index) {
		return scheduleTimeFormat(row.testTime) + ' ' + scheduleDateFormat(row.testDate);
	}

	function scheduleStudentFormat(value, row, index) {
		return [row.studentName, row.phone, row.note].join('<br />');
	}
	function adviceSubjectInfo(value, item, index) {
				return [item.subjectName, item.className].join('<br />');
			}

			function adviceStatusInfo(value, item, index) {
				return [item.adviceName, scheduleDateTimeFormat(value, item, index), adviceStatusFormatter(item.status)]
					.join('<br />');
			}
		</script>
		</div>
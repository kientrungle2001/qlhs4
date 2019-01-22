<div>
	<div style="float: left; width: 350px">
		{include grid/subject/center/datagrid}
	</div>
	<div style="float: left; width: auto; margin-left:15px;">
		<div class="easyui-tabs" style="width: 850px;">
			<div title="Các lớp">
				{include grid/subject/center/classes}
			</div>
			<div title="Học sinh">
				{include grid/subject/center/student}
			</div>
			<div title="Giáo viên">
				{include grid/subject/center/teacher}
			</div>
			<div title="Học phí">
				{include grid/subject/center/student_order}
			</div>
			<div title="Bài thi">
			{include grid/subject/center/test_class}
			</div>
			<div title="Kết quả thi">
			{include grid/subject/center/test_student_mark}
			</div>
			<div title="Thời khóa biểu">
				<div id="calendar" style="padding: 10px;">
					<input type="text" name="week" id="weekSelector" value="<?php echo date('Y-W');?>" />
					<button type="submit" name="submit" id="weekSubmit" onClick="showCalendar(); return false;">Xem</button>
				</div>
				<div id="calendarResult" style="padding: 10px;"></div>
			</div>
		</div>
	</div>
	<script>
	function studentRowStyler(index, row) {
		var style = '';
		if(row.color !== '') {
			style += 'color:' + row.color + ';';
		}
		
		if(row.fontStyle !== '') {
			if(row.fontStyle === 'bold')
				style += 'font-weight: bold;';
			else if(row.fontStyle === 'italic') {
				style += 'font-style: italic;';
			} else if(row.fontStyle === 'underline') {
				style += 'text-decoration: underline;';
			}
		}
		if(style === '') {
			var studentDate = new Date(row.startStudyDate);
			var currentDate = new Date();
			return (currentDate.getTime() - studentDate.getTime() > 365 * 24 * 3600 * 1000) ?  'color: grey;': '';
		} else {
			return style;
		}
	}

	function showCalendar() {
		var week = $('#weekSelector').val();
		var subjectId = pzk.elements.dg.getSelected('id');
		if(!week) {
			alert('Nhập tuần');
			return false;
		}
		if(!subjectId) {
			alert('Chọn môn để xem');
			return false;
		}
		$.ajax({
			url: BASE_URL + '/index.php/schedule/subject',
			type: 'post',
			data: {
				week: week,
				subjectId: subjectId
			},
			success: function(resp) {
				$('#calendarResult').html(resp);
			}
		});
	}
	</script>
</div>
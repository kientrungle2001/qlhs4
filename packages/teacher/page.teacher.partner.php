<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		<?php $defaultFilters = array('type' => 3); ?>
		{include grid/teacher/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Trả lương">
			{include grid/teacher/billing}
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
	function showCalendar() {
		var week = $('#weekSelector').val();
		var teacherId = pzk.elements.dg.getSelected('id');
		if(!week) {
			alert('Nhập tuần');
			return false;
		}
		if(!teacherId) {
			alert('Chọn giáo viên để xem');
			return false;
		}
		$.ajax({
			url: BASE_URL + '/index.php/schedule/teacher',
			type: 'post',
			data: {
				currentWeek: week,
				teacherId: teacherId,
				isAjax: true
			},
			success: function(resp) {
				$('#calendarResult').html(resp);
			}
		});
	}
	</script>
</div>
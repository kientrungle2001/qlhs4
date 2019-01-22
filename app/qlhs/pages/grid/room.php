<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="width: 400px; float: left;">
		{include grid/room/datagrid}
	</div>
	<div style="width: 800px;float: left; margin-left: 10px;">
		<div class="easyui-tabs" style="width: 800px;">
			<div title="Các lớp">
				{include grid/room/classes}
			</div>
			<div title="Tài sản">
				{include grid/room/asset}
			</div>
			<div title="Các buổi học">
			{include grid/room/schedule}
			</div>
			<div title="Lịch phòng">
				Lịch phòng
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
	<div style="clear: both;"></div>
	<script type="text/javascript">
		function searchClasses() {
			pzk.elements.dg_classes.filters({
				'teacherId' : jQuery('#searchTeacher').val(), 
				'subjectId': jQuery('#searchSubject').val(), 
				'level': jQuery('#searchLevel').val(),
				'status': jQuery('#searchStatus').val(),
				'roomId': pzk.elements.dg.getSelected('id')
			});
		}
		function searchRoom() {
			pzk.elements.dg_schedule.filters({
				'roomId': pzk.elements.dg.getSelected('id')
			});
		}
		function searchAsset() {
			pzk.elements.dg_asset.filters({
				'roomId': pzk.elements.dg.getSelected('id')
			});
		}
		
	</script>
	<script>
	function showCalendar() {
		var week = $('#weekSelector').val();
		var roomId = pzk.elements.dg.getSelected('id');
		if(!week) {
			alert('Nhập tuần');
			return false;
		}
		if(!roomId) {
			alert('Chọn phòng để xem');
			return false;
		}
		$.ajax({
			url: BASE_URL + '/index.php/schedule/room',
			type: 'post',
			data: {
				currentWeek: week,
				roomId: roomId,
				isAjax: true
			},
			success: function(resp) {
				$('#calendarResult').html(resp);
			}
		});
	}
	</script>
</div>


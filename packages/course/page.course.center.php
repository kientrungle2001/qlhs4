<div>
<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div style="float:left; width: 220px;">
	{include grid/course/center/subject}
	{include grid/course/center/level}
	{include grid/course/center/teacher}
</div>
<div style="float:left; width: 500px;">
	{include grid/course/center/datagrid}
</div>
<div style="float:left; margin-left: 20px; margin-top: 20px; width: auto;">
 <div class="easyui-tabs" style="width: 550px;">
		<div title="Xếp lịch">
			{include grid/course/center/form_schedule}
		</div>
		<div>
			<div style="float:left; width: 220px;">
				{include grid/course/center/schedule}
			</div>
			<div style="float:left; width: 320px;">
				{include grid/course/center/tuition_fee}
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div title="Học sinh">
		<div class="easyui-tabs">
			<div title="Danh sách">
				{include grid/course/center/student_datagrid}
			</div>
			<div title="Điểm danh">
				{include grid/course/center/student_muster}
			</div>
		</div>
	</div>

	<div title="Giáo viên">
		<div class="easyui-tabs" tabPosition="top">
			<div title="Danh sách">
				{include grid/course/center/teacher_datagrid}
			</div>
			<div title="Điểm danh">
				{include grid/course/center/teacher_muster}
			</div>
		</div>
	</div>
	<div title="Học phí">
		{include grid/course/center/student_order}
	</div>
	<div title="Bài thi">
		{include grid/course/center/test_class}
	</div>
	<div title="Kết quả thi">
		{include grid/course/center/test_mark}
	</div>
	
	<div title="Thời khóa biểu">
		<div id="calendar" style="padding: 10px;">
			<input type="text" name="month" id="monthSelector" value="<?php echo date('Y-m');?>" />
			<button type="submit" name="submit" id="monthSubmit" onClick="showCalendar(); return false;">Xem</button>
		</div>
		<div id="calendarResult" style="padding: 10px;"></div>
	</div>
</div>
</div>
<div class="clear" />
{include grid/course/center/script}
</div>

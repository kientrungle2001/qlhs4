<div>
	<div style="float:left; width: 220px;">
		{include grid/course/online/subject}
		{include grid/course/online/level}
		{include grid/course/online/teacher}
	</div>
	<div style="float:left; width: 500px;">
		{include grid/course/online/datagrid}
	</div>
	<div style="float:left; margin-left: 20px; margin-top: 0; width: auto;">
		<div class="easyui-tabs" style="width: 500px">
			<div title="Học sinh">
			{include grid/course/online/student}
			</div>
			<div title="Tư vấn">
			{include grid/course/online/advice}
			</div>
			<div title="Báo lỗi">
			{include grid/course/online/problem}
			</div>
		</div>
	</div>
	<div class="clear" />
	<script type="text/javascript">
		function searchClasses() {
			pzk.elements.dg.search({
				'fields': {
					'teacherId' : '#searchTeacher', 
					'subjectId': '#searchSubject', 
					'level': '#searchLevel',
					'status': '#searchStatus'
				}
			});
		}
		function searchTeacher() {
			pzk.elements.dgteacher.search({
				'fields': {
					'subjectId': '#searchTeacherSubject', 
					'level': '#searchTeacherLevel'
				}
			});
		}
	</script>
</div>

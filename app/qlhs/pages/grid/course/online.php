<div>
	<div style="float:left; width: 220px;">
		{include grid/course/online/subject}
		{include grid/course/online/level}
		{include grid/course/online/teacher}
	</div>
	<div style="float:left; width: 500px;">
		{include grid/course/online/datagrid}
	</div>
	<div style="float:left; margin-left: 20px; margin-top: 20px; width: auto;">
		<div layout="form/schedule">
			<layout.toolbarItem action="$dg.actOnSelected({
				'url': '{url /dtable/addschedule}', 
				'gridField': 'classId', 
				'fields': {
					'startDate': 'input[name=startDate]',
					'endDate' : 'input[name=endDate]',
					'weekday' : '#weekday',
					'studyTime' : '#studyTime'
				}
			}); $dg2.reload();" icon="ok" />
		</div>
		<div>
			<div style="float:left; width: 220px;">
			{include grid/course/online/schedule}
			</div>
			<div style="float:left; width: 320px;">
				{include grid/course/online/tuition_fee}
			</div>
			<div class="clear"></div>
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

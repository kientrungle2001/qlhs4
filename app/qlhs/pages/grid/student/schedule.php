<div>
<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<dg.dataGrid id="dg" title="Quản lý điểm danh" scriptable="true" table="student_schedule" 
		width="800px" height="500px" rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="120">Ngày học</dg.dataGridItem>
	<dg.dataGridItem field="status" formatter="studentScheduleStatusFormatter" width="40">TT</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="searchStudentSchedule(); return false;">
		<edu.studentSelector label="Học sinh" id="searchStudent" name="studentId"
				onChange="searchStudentSchedule();" />
			<edu.courseSelector label="Lớp" id="searchCourse" name="classId"
				onChange="searchStudentSchedule();" />
		</hform>
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>

</dg.dataGrid>
<script>
function searchStudentSchedule() {
	pzk.elements.dg.search({
		'fields': {
			'classId' : '#searchCourse',
			'studentId' : '#searchStudent' 
		}
	});
}

function studentScheduleStatusFormatter(value, row, index) {
	switch(value) {
		case '1': return 'CM';
		case '2': return 'NTT';
		case '3': return 'NKT';
		case '4': return 'KTT';
		case '5': return 'DH';
		default: return 'N/A';
	}
}
</script>
</div>
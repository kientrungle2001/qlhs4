<div>
	<div style="float:left; width: 220px;">
		<strong style="color: orange;">Môn học</strong><br />
		<form.filter id="sjft" sql="select id as value, name as label from subject" onselect="jQuery('#searchSubject').val(this.value); searchClasses();" />
		<strong style="color: orange;">Trình độ</strong><br />
		<form.filter id="sjlevel" sql="select distinct(level) as value, concat('Lớp ', level) as label from classes" onselect="jQuery('#searchLevel').val(this.value); searchClasses();" />
		<strong style="color: orange;">Lớp</strong><br />
		<dg.dataGrid id="dg" title="" table="classes&filters[status]=1" width="200px" height="500px" pagination="false" pageSize="50" rownumbers="false">
			<!--dg.dataGridItem field="id" width="40">Id</dg.dataGridItem-->
			<dg.dataGridItem field="name" width="120"></dg.dataGridItem>
			
			<layout.toolbar id="dg_toolbar" style="display: none;">
				<hform id="dg_search">
					<form.combobox 
							id="searchSubject" name="subjectId"
							sql="select id as value, 
									name as label from `subject` order by name ASC"
							layout="category-select-list"></form.combobox>
					<form.combobox 
							id="searchLevel" name="level"
							sql="select distinct(level) as value, level as label from classes order by label asc"
							layout="category-select-list"></form.combobox>
					<layout.toolbarItem action="searchClasses()" icon="search" />
					<layout.toolbarItem action="$dg.detail(function(row) { 
						jQuery.ajax({url: '{url /demo/musterTab}?classId='+row.id, success: function(resp) {
							jQuery('#musterDetail').html(resp);
							jQuery.parser.parse('#musterDetail');
						}});  
					});" icon="sum" />
				</hform>
			</layout.toolbar>
		</dg.dataGrid>
		<script type="text/javascript">
			function searchClasses() {
				pzk.elements.dg.search({
					'fields': {
						'subjectId': '#searchSubject', 
						'level': '#searchLevel'
					}
				});
			}
		</script>
		<script type="text/javascript">

function submitMuster(classId, studentId, studyDate, status) {
	$.ajax({
		type: 'post',
		method: 'post',
		url: BASE_URL + '/index.php/Dtable/replace?table=student_schedule',
		data: {classId: classId, studentId: studentId, studyDate: studyDate, status: status},
		success: function(result) {
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}
		}
	});
}

function submitClassMuster(classId, studyDate, status) {
	$('.muster_' + classId + '_' + studyDate).val(status);
	$('.muster_' + classId + '_' + studyDate).change();
}

function submitTeacherMuster(classId, studyDate, teacherId) {
	$.ajax({
		type: 'post',
		method: 'post',
		url: BASE_URL + '/index.php/Dtable/replace?table=teacher_schedule',
		data: {classId: classId, teacherId: teacherId, studyDate: studyDate, status: 1},
		success: function(result) {
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			}
		}
	});
}

function submitAllTeacherMuster(classId, periodId, status) {
	$('.muster_teacher_' + classId + '_' + periodId).val(status);
	$('.muster_teacher_' + classId + '_' + periodId).change();
}

function submitStudentMuster(classId, periodId, studentId, status) {
	$('.muster_student_' + classId + '_' + periodId + '_' + studentId).val(status);
	$('.muster_student_' + classId + '_' + periodId + '_' + studentId).change();
}
</script>
	</div>
	<div style="float:left; width: 600px;">
		<div id="musterDetail"></div>
		<!--edu.paymentstat>
		</edu.paymentstat-->
		<!--edu.muster>
		</edu.muster-->
	</div>
	<div class="clear" />
</div>

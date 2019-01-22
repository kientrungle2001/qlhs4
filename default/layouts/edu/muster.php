<script type="text/javascript" src="<?php echo BASE_URL;?>/lib/js/date.js"></script>
	<?php 
		$classes = $data->getClasses();
		$arrcls = array();
		foreach($classes as $class) {
			$subjectId = $class['subjectId'];
			if(!isset($arrcls[$subjectId])) {
				$arrcls[$subjectId] = array();
			}
			$arrcls[$subjectId][] = $class;
		}
	?>
{each $arrcls as $clss}
<div class="easyui-tabs" style="width:1360px;height:auto;">
	<div title="Điểm danh">
		<h1><center>Điểm danh học sinh</center></h1>
	</div>
	{each $clss as $class}
	<div title="{class[name]}" data-options="href:'{url /demo/musterTab}?classId={class[id]}',closable:true">	
	</div>
	{/each}
</div>
{/each}
<strong>Lưu ý: </strong> N/A: Chưa điểm danh, CM: Có mặt, NTT: Nghỉ trừ tiền, NKT: Nghỉ không trừ tiền
{children all}
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

function submitStudentMuster(classId, periodId, studentId, status) {
	$('.muster_student_' + classId + '_' + periodId + '_' + studentId).val(status);
	$('.muster_student_' + classId + '_' + periodId + '_' + studentId).change();
}

function submitAllTeacherMuster(classId, periodId, status) {
	$('.muster_teacher_' + classId + '_' + periodId).val(status);
	$('.muster_teacher_' + classId + '_' + periodId).change();
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

</script>
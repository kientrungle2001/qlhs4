<?php 
	$class = $data->getClass();
	$dates = $data->getStudyDates($class['id']);
	$students = $data->getStudents($class['id']);
	$teachers = $data->getTeachers(@$class['teacherId'], @$class['teacher2Id']);
	$periods = $data->getPaymentPeriods($class['id']);
	$statuses = $data->getStatuses();
	$teacherStatuses = $data->getTeacherStatuses();
?>
	<div class="easyui-tabs" style="width:1340px;height:auto;padding: 5px;">
	{each $periods as $period}
		<?php if($class['startDate'] !== '0000-00-00' && $class['startDate'] >= $period['endDate']) { continue; }?>
		<?php if($class['endDate'] !== '0000-00-00' && $class['endDate'] < $period['startDate']) { continue; }?>
		<div title="{period[name]}">
			<a href="{url /demo/musterPrint}?classId={class[id]}&periodId={period[id]}" target="_blank"><h2>Xem bản in</h2></a><br />
			<table border="1" cellpadding="4px" cellspacing="0" style="border-collapse:collapse;margin: 15px;">
				<tr>
					<th>STT</th>
					<th>&nbsp;<br />Điểm danh tất cả<br />Giáo viên dạy</th>
					{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<th>{? echo date('d/m', strtotime($date['studyDate']))?}
					<br />
					<select id="muster_{class[id]}_{date[studyDate]}"
							onchange="submitClassMuster('{class[id]}', '{date[studyDate]}', this.value)">
						<option value="0">N/A</option>
						<option value="1">CM</option>
						<option value="2">NTT</option>
						<option value="3">NKT</option>
						<option value="4">KTT</option>
						<option value="5">DH</option>
					</select>
					<br />
					<select id="teacher_{class[id]}_{date[studyDate]}" onchange="submitTeacherMuster('{class[id]}', '{date[studyDate]}', this.value)">
						<option value="0">---</option>
						<?php if (@$class['teacherId']) { 
							$teacher = $teachers[$class['teacherId']]; 
							$names = explode(' ', $teacher['name']);
							$name = array_pop($names);
							?>
							<option value="{class[teacherId]}">{name}</option>
						<?php } ?>
						<?php if (@$class['teacher2Id']) { 
							$teacher2 = $teachers[$class['teacher2Id']];
							$names = explode(' ', $teacher2['name']);
							$name2 = array_pop($names); ?>
							<option value="{class[teacher2Id]}">{name2}</option>
						<?php } ?>
					</select>
					</th>
					<?php } ?>
					{/each}
				</tr>
				<?php $index = 0;?>
				{each $students as $student}
				<?php if ($student['endStudyDate'] !== '0000-00-00' && $student['endStudyDate'] < $period['startDate']) { continue; } ?>
				<?php if ($student['startStudyDate'] !== '0000-00-00' && $student['startStudyDate'] > $period['endDate']) { continue; } ?>
				<?php if ($student['endClassDate'] !== '0000-00-00' && $student['endClassDate'] < $period['startDate']) { continue; } ?>
				<?php if ($student['startClassDate'] !== '0000-00-00' && $student['startClassDate'] > $period['endDate']) { continue; } ?>
				<?php $index++;?>
				<tr>
					<td>{index}</td>
					<td>{student[name]}</td>
					{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<?php if ($student['startStudyDate'] == '0000-00-00' || $student['startStudyDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endStudyDate'] == '0000-00-00' || $student['endStudyDate'] > $date['studyDate']) { ?>
					<?php if ($student['startClassDate'] == '0000-00-00' || $student['startClassDate'] <= $date['studyDate']) { ?>
					<?php if ($student['endClassDate'] == '0000-00-00' || $student['endClassDate'] > $date['studyDate']) { ?>
					<td><select class="muster_{class[id]}_{date[studyDate]}" id="muster_{class[id]}_{student[id]}_{date[studyDate]}" name="muster[{class[id]}][{student[id]}][{date[studyDate]}]"
							onchange="submitMuster('{class[id]}', '{student[id]}', '{date[studyDate]}', this.value)">
						<option value="0">N/A</option>
						<option value="1">CM</option>
						<option value="2">NTT</option>
						<option value="3">NKT</option>
						<option value="4">KTT</option>
						<option value="5">DH</option>
					</select>
					</td>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					{/each}
				</tr>
				{/each}
				<tr>
					<th>&nbsp;</th>
					<th>&nbsp;<br />Tổng kết</th>
					{each $dates as $date}
					<?php if ($date['studyDate'] >= $period['startDate'] && $date['studyDate'] < $period['endDate']) { ?>
					<th id="tongket-{class[id]}-{date[studyDate]}">{? echo date('d/m', strtotime($date['studyDate']))?}<br />
						N/A: <span rel="0"></span><br />
						CM: <span rel="1"></span><br />
						NTT: <span rel="2"></span><br />
						NKT: <span rel="3"></span><br />
						KTT: <span rel="4"></span><br />
						DH: <span rel="5"></span>
					</th>
					<?php } ?>
					{/each}
				</tr>
			</table>
		</div>
		
	{/each}
	</div>
	
<script type="text/javascript">
var statuses = <?php echo json_encode($statuses)?>;
var teacherStatuses = <?php echo json_encode($teacherStatuses)?>;
var summary = {};
$(document).ready(function(e) {
	for(var i=0; i < statuses.length; i++) {
		
		var classId = statuses[i]['classId'];
		var studentId = statuses[i]['studentId'];
		var studyDate = statuses[i]['studyDate'];
		var status = statuses[i]['status'];
		$('#muster_' + classId + '_' + studentId + '_' + studyDate).val(status);
		var num = $('#tongket-' + classId + '-' + studyDate + ' span[rel='+status+']').text();
		num = parseInt(num) || 0;
		num++;
		$('#tongket-' + classId + '-' + studyDate + ' span[rel='+status+']').text(num);
	}
	
	for(var i=0; i < teacherStatuses.length; i++) {
		var classId = teacherStatuses[i]['classId'];
		var teacherId = teacherStatuses[i]['teacherId'];
		var studyDate = teacherStatuses[i]['studyDate'];
		$('#teacher_' + classId + '_' + studyDate).val(teacherId);
	}
});
</script>
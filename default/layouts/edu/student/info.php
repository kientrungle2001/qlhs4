<?php
$student = _db()->getEntity('edu.student')->load(pzk_session('studentId'));
$classes = $student->getClasses();
?>
<h2>Thông tin học sinh - {? echo $student->getName(); ?}</h2>
<hr />
<div class="easyui-tabs">
{each $classes as $class}
<?php if($class->getSubjectId()==3) { ?>
<div title="Lớp {? echo $class->getName(); ?}" class="padding10">
<?php
$studentsInClass = $class->getStudents('student.name', $student->getId());
if($studentsInClass) {
	$studentInClass = $studentsInClass[0];
}
$studyDates = $studentInClass->getStudyDates();
?>
<h2>Điểm số</h2>
<table class="table" border="1" style="border-collapse: collapse;">
<tr>
	<th title="Buổi" style="width: 150px;">Buổi</th>
	<th title="Điểm" style="width: 80px;">Điểm</th>
	<th title="Nhận xét">Nhận xét</th>
</tr>
<?php $first = false; ?>
{each $studyDates as $studyDate}
<tr>
	<td title="{? echo $studyDate->getPeriodId(); ?}">Buổi {? echo ($studyDate->getPeriodId()); ?}</td>
	<td title="{? echo $studyDate->getPeriodId(); ?}">{? echo $studyDate->getMarks(); ?}&nbsp;</td>
	<?php if (!$first) { ?>
	<td rowspan="16" valign="top">{? echo $studentInClass->getNote(); ?}</td>
	<?php 
			$first = true;
		} ?>
</tr>
{/each}

</table>
</div>
<?php } else { ?>
<div title="Lớp {? echo $class->getName(); ?}" class="padding10">
<?php
$studentsInClass = $class->getStudents('student.name', $student->getId());
if($studentsInClass) {
	$studentInClass = $studentsInClass[0];
}
$periods = $studentInClass->getPeriods();
?>
<h2>Điểm số</h2>
<table class="table" border="1" style="border-collapse: collapse;">
<tr>
	<th title="Kỳ học" style="width: 150px;">Kỳ học</th>
	<th title="Điểm" style="width: 80px;">Điểm</th>
	<th title="Nhận xét">Nhận xét</th>
</tr>
{each $periods as $period}
<tr>
	<td title="{? echo $period->getName(); ?}">{? echo $period->getName(); ?}</td>
	<td title="{? echo $period->getName(); ?}">{? echo $period->getMarks(); ?}&nbsp;</td>
	<td title="Nhận xét" valign="top">{? echo $period->getNote(); ?}</td>
</tr>
{/each}

</table>
</div>
<h2>Nhận xét của giáo viên</h2>
<p>{? echo nl2br($class->getNote()); ?}</p>
<?php } ?>
{/each}
</div>
<style>
.padding10 {
	padding: 10px;
}
.table {
	width: 75%;
}
.table tr td, .table tr th{
	padding: 10px;
}
</style>
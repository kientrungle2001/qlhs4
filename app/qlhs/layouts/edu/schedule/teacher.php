<?php if(!$data->getIsAjax()):?>
<?php $teachers = _db()->selectAll()->fromTeacher()->result();?>
<h1>Thời khóa biểu giáo viên</h1>
<form method="get">
	<input name="currentWeek" value="{data.currentWeek}" />
	<select name="teacherId">
	{each $teachers as $teacher}
<option value="{teacher[id]}" <?php if($teacher['id'] == $data->getTeacherId()):?>selected<?php endif;?>>{teacher[name]}</option>
	{/each}
	</select>
	<button type="submit">Xem</button>
</form>
<?php endif;?>

<?php if($data->getTeacherId()):?>
<?php
$bgs = array(
	'1' => '#abc',
	'2'	=>	'#bac',
	'3'	=>	'#cba'
);
$schedules = $data->getSchedules();
$dailies = array();
foreach($schedules as $schedule) {
	if(!isset($dailies[$schedule['studyDate']])) {
		$dailies[$schedule['studyDate']] = array();
	}
	$dailies[$schedule['studyDate']][] = $schedule;
}
?>
<div class="schedule-daily">
<?php foreach($dailies as $day => $schedules):?>
	<div class="schedule-daily-item" style="height: auto; width: 90%;">
		<div class="room-name"><?php echo date('D d/m', strtotime($day));?></div>
		{each $schedules as $schedule}
			<div class="class-name" style="background: <?php echo $bgs[$schedule['subjectId']]?>; margin-bottom: 3px;padding: 5px; text-align: justify">{schedule[roomName]} - {schedule[className]} - {schedule[subjectName]} - {schedule[teacherName]}</div>
		{/each}
	</div>
<?php endforeach;?>
</div>
<?php endif;?>
<h1>Thời khóa biểu theo ngày</h1>
<form method="get">
	<input type="date" name="currentDate" value="{data.currentDate}" />
	<button type="submit">Xem</button>
</form>

<?php
$schedules = $data->getSchedules();
?>
<div class="schedule-daily">
{each $schedules as $schedule}
	<div class="schedule-daily-item">
		<div class="room-name">{schedule[roomName]}</div>
		<div class="subject-name">{schedule[subjectName]}</div>
		<div class="teacher-name">{schedule[teacherName]}</div>
		<div class="class-name">{schedule[className]}</div>
		<div class="study-time">{schedule[studyTime]}</div>
	</div>
{/each}
</div>
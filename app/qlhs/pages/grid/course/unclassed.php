<div>
	<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
	<div style="float:left; width: 220px;">
		{include grid/course/center/subject}
		{include grid/course/center/level}
		{include grid/course/center/teacher}
	</div>
	<div style="float:left; width: 500px;">
		<?php $defaultFilters = array('online' => 0, 'classed' => -1); ?>
		{include grid/course/unclassed/datagrid}
	</div>
	<div style="float:left; width: 500px;">
		<div class="easyui-tabs" style="width: 500px;">
			<div title="Học sinh">
			{include grid/course/unclassed/student}
			</div>
			<div title="Lịch hẹn test">
			{include grid/course/unclassed/ontest}
			</div>
		</div>
	</div>
	<div class="clear" />
	{include grid/course/center/script}
</div>
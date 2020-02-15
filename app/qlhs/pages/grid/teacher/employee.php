<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		<?php $defaultFilters = array('type' => 2); ?>
		{include grid/teacher/employee/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Học sinh">
				{include grid/teacher/student}
			</div>
			<div title="Test đầu vào">
			{include grid/teacher/ontest}
			</div>
			<div title="Tư vấn">
			{include grid/teacher/advice}
			</div>
			<div title="Báo lỗi">
			{include grid/teacher/problem}
			</div>
			<div title="Trả lương">
			{include grid/teacher/billing}
			</div>
		</div>
	</div>
</div>
<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		{include grid/plan/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Công việc">
				{include grid/plan/task}
			</div>
		</div>
	</div>
</div>
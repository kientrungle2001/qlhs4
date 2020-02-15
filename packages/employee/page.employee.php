<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		{include grid/employee/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Bảng lương">
				{include grid/employee/billing}
			</div>
		</div>
	</div>
</div>
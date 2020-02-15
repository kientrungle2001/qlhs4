<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="width: 400px; float: left;">
		{include grid/department/datagrid}
	</div>
	<div style="width: 800px;float: left; margin-left: 10px;">
		<div class="easyui-tabs" style="width: 800px;">
			<div title="Nhân viên">
				{include grid/department/teacher}
			</div>
			<div title="Bảng lương">
				{include grid/teacher/billing}
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>


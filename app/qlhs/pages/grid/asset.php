<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="width: 400px; float: left;">
		{include grid/asset/datagrid}
	</div>
	<div style="width: 800px;float: left; margin-left: 10px;">
		<div class="easyui-tabs" style="width: 800px;">
			<div title="Lịch sử bàn giao">
			{include grid/asset/schedule/teacher}
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>


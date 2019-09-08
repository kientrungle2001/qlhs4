<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		{include grid/center/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs" style="width: 650px;">
			<div title="Phòng học">
			{include grid/center/room}
			</div>
			<div title="Các lớp">
			{include grid/center/classes}
			</div>
			<div title="Tài sản">
			{include grid/center/asset}
			</div>
			<div title="Các buổi học">
			{include grid/center/schedule}
			</div>
		</div>
	</div>
</div>
<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		{include grid/partner/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Bảng trả phí">
				{include grid/partner/billing}
			</div>
		</div>
	</div>
</div>
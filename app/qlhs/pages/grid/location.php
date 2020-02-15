<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 550px;">
		<?php
		$defaultFilters = array(
			'type' => 'province'
		);
		?>
		{include grid/location/datagrid}
	</div>
	<div style="float: left; width: 650px;">
		<div class="easyui-tabs">
			<div title="Quận huyện">
			</div>
		</div>
	</div>
</div>
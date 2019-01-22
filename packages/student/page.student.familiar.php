<div style="margin-top: 10px;">
	<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
	<div class="clear"></div>

	<div style="float:left; width: 600px;">
	<?php 
		$filters = array(
			'online' 			=> 1,
			'type'						=>	2,
		);
		$defaultAdd = array_merge($filters, array(
			'status'				=> 1,
			'classed'			=>	1,
			'rating'				=> 0,
			'color'					=> 	'',
			'fontStyle' => '',
			'assignId'		=>	''
		));
		$defaultClassFilters = array(
			'status'	=>	1,
			'online'	=>	1
		);
	?>
	{include grid/student/online/datagrid}
	</div>
	<div style="float:left; margin-left: 10px; margin-top: 0px; width: auto;">
		{include grid/student/online/classify_student}
		<div id="student-detail"></div>
	</div>
	<div style="clear:both;"></div>
	{include grid/student/component/script}
</div>

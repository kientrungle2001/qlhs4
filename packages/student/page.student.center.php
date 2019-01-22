<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
	<?php 
		$filters = array(
			'online' 			=> 0
		);
		$defaultAdd = array_merge($filters, array(
			'status'				=> 1,
			'classed'			=>	1,
			'type'						=>	1,
			'rating'				=> 0,
			'color'					=> 	'',
			'fontStyle' => '',
			'assignId'		=>	''
		));
	?>
<div style="margin-top: 10px;">
	<div class="clear"></div>
	<div style="float:left; width: 700px;">
		{include grid/student/component/datagrid}
	</div>
	<div style="float:left; margin-left: 10px; margin-top: 0px; width: 600px;">
		{include grid/student/component/classify_student}
		<div id="student-detail"></div>
	</div>
	<div style="clear:both;"></div>
	{include grid/student/component/script}
</div>

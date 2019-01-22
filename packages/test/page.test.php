<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 400px;">
		{include grid/test/datagrid}
	</div>
<div style="float: left; width: 800px;">
	<div class="easyui-tabs">
		<div title="Các lớp">
			{include grid/test/test_class}
		</div>
		<div title="Điểm thi">
			{include grid/test/test_student_mark}
		</div>
	</div>
	</div>
	<div style="clear: both;">&nbsp;</div>
	<script>
	function searchClassesByTest(row) {
		$('#cmbTest').val(row.id);
		pzk.elements.dg_test_class.search({
			builder: function() {
				return {
					testId: row.id
				};
			}
		});
	}
	function searchStudentMark(row) {
		pzk.elements.dg_test_student_mark.search({
			builder: function() {
				return {
					testId: row.id
				};
			}
		});
	}
	</script>
</div>

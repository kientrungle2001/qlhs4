<!-- Danh sách học sinh  -->
<?php if(!isset($filters)):
	$filters = array('online' => 0);
endif;
if(!isset($defaultAdd)) {
	$defaultAdd = $filters;
}
if(!isset($defaultClassFilters)) {
	$defaultClassFilters = array(
		'status'	=>	1,
		'online'	=>	0
	);
}
?>
<script>
<![CDATA[
	var studentDefaultFilters = <?php echo json_encode($filters); ?>;
	var studentDefaultAdd = <?php echo json_encode($defaultAdd); ?>;
]]>
</script>
<dg.dataGrid id="dg" title="Quản lý học sinh" scriptable="true" layout="easyui/datagrid/datagrid" 
		onRowContextMenu="studentMenu" nowrap="false"
		table="student" width="700px" height="550px"
		rowStyler="studentRowStyler" defaultFilters='<?php echo json_encode($filters)?>'>
	<!--dg.dataGridItem field="id" width="40">Id</dg.dataGridItem-->
	<dg.dataGridItem field="name" width="140" formatter="studentNameFormatter">Tên học sinh</dg.dataGridItem>
	<!--dg.dataGridItem field="school" width="120">Trường</dg.dataGridItem-->
	<dg.dataGridItem field="currentClassNames" width="100">Lớp</dg.dataGridItem>
	<!--dg.dataGridItem field="classNames" width="100">Lớp Đã Học</dg.dataGridItem-->
	<dg.dataGridItem field="periodNames" width="100">Kỳ thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="note" width="140" formatter="studentNoteFormatter">Ghi chú</dg.dataGridItem>
	<!-- Toolbar cho danh sách học sinh -->
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="searchStudent(); return false;">
			<input width="120px" name="keyword" id="searchKeyword" onKeyUp="searchStudent();" placeholder="Tìm kiếm" />
			<a href="#" onClick="jQuery(this).next().toggle();jQuery(this).toggle();return false;">Nâng cao</a>
			<span style="display: none;">
			
			<edu.courseSelector name="classIds" id="searchClassIds" onChange="searchStudent();" defaultFilters='<?php echo json_encode($defaultClassFilters)?>' />
			<br />
			<form.selectbox  id="searchPeriod" name="periodId"
				sql="{payment_period_sql}" onChange="searchStudent();" label="Chọn kỳ thanh toán" />
			<form.selectbox label="Chọn kỳ chưa thanh toán" id="searchnotlikePeriod" name="notlikeperiodId"
				sql="{payment_period_sql}" onChange="searchStudent();" />
				<form.selectbox label="Người phụ trách" id="searchAssignId" name="assignId"
				sql="{teacher_sql}" onChange="searchStudent();" />
				<br />
			<form.selectbox label="Chọn màu" 
					name="color" id="searchColor" onChange="searchStudent();">
				<option value="red">Đỏ</option>
				<option value="blue">Xanh da trời</option>
				<option value="green">Xanh lá cây</option>
				<option value="yellow">Vàng</option>
				<option value="purple">Tím</option>
				<option value="grey">Xám</option>
			</form.selectbox>
			<form.selectbox label="Chọn kiểu" 
					name="fontStyle" id="searchFontStyle" onChange="searchStudent();">
				<option value="bold">Đậm</option>
				<option value="italic">Nghiêng</option>
				<option value="underline">Gạch chân</option>
			</form.selectbox>
			
			<?php if(!isset($filters['type'])): ?>
			<form.selectbox name="type" id="searchType" onChange="searchStudent();" label="Phân loại">
				<option value="1">Đã học</option>
				<option value="0">Tiềm năng</option>
				<option value="2">Lâu năm</option>
			</form.selectbox>
			<?php endif;?>
			<form.selectbox name="rating" id="searchRating" onChange="searchStudent();"
					label="Xếp hạng">
				<option value="0">Chưa xếp hạng</option>
				<option value="1">Kém</option>
				<option value="2">Trung Bình</option>
				<option value="3">Khá</option>
				<option value="4">Giỏi</option>
				<option value="5">Xuất Sắc</option>
			</form.selectbox>
			<?php if(!isset($filters['status'])): ?>
			<form.selectbox name="status" id="searchStatus" onChange="searchStudent();"
					label="Trạng thái">
				<option value="1">Đang học</option>
				<option value="0">Dừng học</option>
			</form.selectbox>
		<?php endif;?>
		<a href="#" onClick="jQuery(this).parent().prev().toggle();jQuery(this).parent().toggle();return false;">Thu gọn</a>
		</span>
			<input type="submit" style="display: none;" value="Tìm" />
			<!--<layout.toolbarItem id="searchButton" action="searchStudent();" icon="search" />-->
			<br />
			<layout.toolbarItem action="$dg.add(studentDefaultAdd)" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail({url: '{url /student/detail}', 'gridField': 'id', 'action': 'render', 'renderRegion': '#student-detail'}); $dg.detail(function(row) { selectClass(row); });" icon="sum" />
			<layout.toolbarItem action="$dg.doExport(); return false;" icon="redo" label="Export" />
			<layout.toolbarItem action="$dg.doImport(); return false;" icon="undo" label="Import" />
			<form.selectbox label="Người phụ trách" id="selectAssignId" name="selectedAssignId"
				sql="{teacher_sql}" />
				<easyui.menu.linkbutton>Gán tư vấn viên</easyui.menu.linkbutton>
			<a href="#" onClick="pzk.elements.dg.toggleSingleSelect();
			if(pzk.elements.dg.singleSelect === 'true') {
				$(this).text('Chế độ chọn nhiều');
			} else {
				$(this).text('Chế độ chọn một');
			}
			 return false;">Chế độ chọn nhiều</a>
		</hform>
	</layout.toolbar>
	<!-- Hết toolbar cho danh sách học sinh -->

	{include grid/student/component/dialog}

</dg.dataGrid>
<!-- Hết form thêm danh sách học sinh -->

<!-- Import Dialog -->
<wdw.dialog layout="easyui/window/dialog" id="dlg_import_student" width="1000px" height="500px;" title="Import học sinh">
	<div id="import_area"></div>
</wdw.dialog>
<dg.export id="export_dg" gridId="dg" table="student" width="700px" height="auto" searchOptions="getStudentSearchOption" />
<dg.import id="import_dg" gridId="dg" table="student" width="700px" height="auto" />
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
	function studentInfo(value, item, index) {
		return [item.name, item.code, item.phone, item.birthDate].join('<br />');
	}
	function serviceInfo(value, item, index) {
		return [item.subjectNames, item.currentClassNames, item.startStudyDate].join('<br />');
	}
	function adviceStatusFormatter(value,row,index) {
		switch(value) {
			case '-2': return 'Đang suy nghĩ';
			case '-1': return 'Từ chối';
			case '0': return 'Chưa gọi';
			case '1': return 'Đã gọi';
			case '2': return 'Đã dùng thử';
			case '3': return 'Đã sử dụng';
		}
	}
	function noteInfo(value, item, index) {
		return [item.note, item.adviceNote, adviceStatusFormatter(item.adviceStatus)].join('<br />');
	}
]]>
</script>
<dg.dataGrid id="dg" title="Quản lý học sinh" scriptable="true" layout="easyui/datagrid/datagrid" 
		onRowContextMenu="studentMenu" nowrap="false"
		table="student" width="600px" height="450px"
		rowStyler="studentRowStyler" defaultFilters='<?php echo json_encode($filters)?>'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140" formatter="studentInfo">Tên học sinh</dg.dataGridItem>
	<!--
	<dg.dataGridItem field="code" width="80">Mã</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	-->
	<!--dg.dataGridItem field="school" width="120">Trường</dg.dataGridItem-->
	<dg.dataGridItem field="subjectNames" width="100" formatter="serviceInfo">Phần mềm</dg.dataGridItem>
	<!--
	<dg.dataGridItem field="subjectNames" width="100">Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="currentClassNames" width="100">Dịch vụ</dg.dataGridItem>
	-->
	<!--dg.dataGridItem field="classNames" width="100">Lớp Đã Học</dg.dataGridItem-->
	<!--dg.dataGridItem field="startStudyDate" width="100">Ngày vào học</dg.dataGridItem-->
	<dg.dataGridItem field="note" width="140" formatter="noteInfo">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="assignName" width="140">Phụ trách</dg.dataGridItem>
	<!-- Toolbar cho danh sách học sinh -->
	<layout.toolbar id="dg_toolbar">
	<hform id="dg_search" onsubmit="searchStudent(); return false;">
			<input width="120px" name="keyword" id="searchKeyword" onKeyUp="searchStudent();" placeholder="Tìm kiếm" />
			<a href="#" onClick="jQuery(this).next().toggle();jQuery(this).toggle();return false;">Nâng cao</a>
			<span style="display: none;">
			<edu.courseSelector name="classIds" id="searchClassIds" onChange="searchStudent();" defaultFilters='<?php echo json_encode($defaultClassFilters)?>' />
			<form.combobox label="Chọn kỳ thanh toán" id="searchPeriod" name="periodId"
				sql="{payment_period_sql}" layout="category-select-list" onChange="searchStudent();"></form.combobox>
			<form.combobox label="Chọn kỳ chưa thanh toán" id="searchnotlikePeriod" name="notlikeperiodId"
				sql="{payment_period_sql}" layout="category-select-list" onChange="searchStudent();"></form.combobox>
			<form.combobox layout="category-select-list" label="Chọn màu" 
					name="color" id="searchColor" onChange="searchStudent();">
				<option value="red">Đỏ</option>
				<option value="blue">Xanh da trời</option>
				<option value="green">Xanh lá cây</option>
				<option value="yellow">Vàng</option>
				<option value="purple">Tím</option>
				<option value="grey">Xám</option>
			</form.combobox>
			<form.combobox layout="category-select-list" label="Chọn kiểu" 
					name="fontStyle" id="searchFontStyle" onChange="searchStudent();">
				<option value="bold">Đậm</option>
				<option value="italic">Nghiêng</option>
				<option value="underline">Gạch chân</option>
			</form.combobox>
			<form.combobox label="Người phụ trách" id="searchAssignId" name="assignId"
				sql="{teacher_sql}" onChange="searchStudent();"
				layout="category-select-list"></form.combobox>
			<?php if(!isset($filters['type'])): ?>
			<form.combobox name="type" id="searchType" onChange="searchStudent();"
					layout="category-select-list"
					label="Phân loại">
				<option value="1">Đã học</option>
				<option value="0">Tiềm năng</option>
				<option value="2">Lâu năm</option>
			</form.combobox>
			<?php endif;?>
			<form.combobox name="rating" id="searchRating" onChange="searchStudent();"
					layout="category-select-list"
					label="Xếp hạng">
				<option value="0">Chưa xếp hạng</option>
				<option value="1">Kém</option>
				<option value="2">Trung Bình</option>
				<option value="3">Khá</option>
				<option value="4">Giỏi</option>
				<option value="5">Xuất Sắc</option>
			</form.combobox>
			<?php if(!isset($filters['status'])): ?>
			<form.combobox name="status" id="searchStatus" onChange="searchStudent();"
					layout="category-select-list"
					label="Trạng thái">
				<option value="1">Đang học</option>
				<option value="0">Dừng học</option>
			</form.combobox>
		<?php endif;?>
		<a href="#" onClick="jQuery(this).parent().prev().toggle();jQuery(this).parent().toggle();return false;">Thu gọn</a>
		</span>
			<input type="submit" style="display: none;" value="Tìm" />
			<layout.toolbarItem id="searchButton" action="searchStudent();" icon="search" />
			<layout.toolbarItem action="$dg.add(studentDefaultAdd)" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail({url: '{url /student/detail}', 'gridField': 'id', 'action': 'render', 'renderRegion': '#student-detail'}); $dg.detail(function(row) { selectClass(row); });" icon="sum" />
			<layout.toolbarItem action="$dg.doExport(); return false;" icon="redo" label="Export" />
			<layout.toolbarItem action="$dg.doImport(); return false;" icon="undo" label="Import" />
		</hform>
	</layout.toolbar>
	<!-- Hết toolbar cho danh sách học sinh -->
	<!-- Dialog thêm sửa học sinh -->
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Học sinh">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên học sinh" />
			<frm.formItem name="phone" label="Số điện thoại" />
			<frm.formItem name="school"  label="Trường" />
			<frm.formItem type="date" name="birthDate" label="Ngày sinh" />
			<frm.formItem name="address" label="Địa chỉ" />
			<frm.formItem name="parentName" label="Phụ huynh" />
			<frm.formItem type="date" name="startStudyDate" label="Ngày nhập học" value="{? echo date('Y-m-d'); ?}" />
			<frm.formItem type="date" name="endStudyDate" label="Ngày dừng học" />
			<frm.formItem name="note" label="Ghi chú" />
			<frm.formItem name="color" label="Màu sắc" type="user-defined">
				<form.selectbox name="color">
					<option value="">Bình thường</option>
					<option value="red">Đỏ</option>
					<option value="blue">Xanh da trời</option>
					<option value="green">Xanh lá cây</option>
					<option value="yellow">Vàng</option>
					<option value="purple">Tím</option>
					<option value="grey">Xám</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="fontStyle" label="Kiểu chữ" type="user-defined">
				<form.selectbox name="fontStyle">
					<option value="">Bình thường</option>
					<option value="bold">Đậm</option>
					<option value="italic">Nghiêng</option>
					<option value="underline">Gạch chân</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="assignId" label="Người phụ trách" type="user-defined">
				<form.selectbox label="Người phụ trách" name="assignId"
			sql="{teacher_sql}"
				></form.selectbox>
			</frm.formItem>
			<frm.formItem name="online" label="Học tại" type="user-defined">
				<form.selectbox name="online" label="Học tại">
					<option value="0">Trung tâm</option>
					<option value="1">Trực tuyến</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="classed" label="Đã xếp lớp" type="user-defined">
				<form.selectbox name="classed" label="Chọn">
					<option value="1">Đã xếp lớp</option>
					<option value="0">Chờ xếp lớp</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="type" label="Phân loại" type="user-defined">
				<form.selectbox name="type" label="Phân loại">
					<option value="1">Đã học</option>
					<option value="0">Tiềm năng</option>
					<option value="2">Lâu năm</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="rating" label="Xếp hạng" type="user-defined">
				<form.selectbox name="rating" label="Xếp hạng">
					<option value="0">Chưa xếp hạng</option>
					<option value="1">Kém</option>
					<option value="2">Trung Bình</option>
					<option value="3">Khá</option>
					<option value="4">Giỏi</option>
					<option value="5">Xuất Sắc</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="status" label="Đã dừng học" type="user-defined">
				<form.selectbox name="status" label="Trạng thái học">
					<option value="1">Đang học</option>
					<option value="0">Dừng học</option>
				</form.selectbox>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
	<!-- Hết dialog thêm sửa học sinh -->
</dg.dataGrid>
<!-- Hết form thêm danh sách học sinh -->

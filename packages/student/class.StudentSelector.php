<?php
class PzkEduStudentSelector extends PzkObject {
	public $layout = 'edu/student/selector';
	public $scriptable = true;
	public $value = null;
	public $onChange = null;
	public $name = null;
	public $rand = null;
	public function init() {
		// Thêm grid
		$this->rand = rand(0, 1000000000);
		pzk_element('left')->append($this->getDialog());
	}
	public function getDialog() {
		$dialogHtml = $this->getDialogHtml();
		return pzk_parse($dialogHtml);
	}
	public function getDialogHtml() {
		require BASE_DIR . '/' . pzk_app()->getUri('constants.php');
		$rand = $this->rand;
  return '
<wdw.dialog id="dlg_student_'.$this->id.'" 
		width="1000px" height="auto" title="Học sinh"
		layout="easyui/window/dialog">
	<dg.dataGrid id="dg_student_'.$this->id.'" title="Quản lý học sinh" scriptable="true" 
			layout="easyui/datagrid/datagrid" 
			onRowContextMenu="studentMenu" nowrap="false"
			table="student" width="950px" height="450px"
			rowStyler="studentRowStyler">
		<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
		<dg.dataGridItem field="name" width="140">Tên học sinh</dg.dataGridItem>
		<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
		<dg.dataGridItem field="school" width="120">Trường</dg.dataGridItem>
		<dg.dataGridItem field="currentClassNames" width="100">Lớp</dg.dataGridItem>
		<dg.dataGridItem field="classNames" width="100">Lớp Đã Học</dg.dataGridItem>
		<dg.dataGridItem field="periodNames" width="100">Kỳ thanh toán</dg.dataGridItem>
		<dg.dataGridItem field="startStudyDate" width="100">Ngày vào học</dg.dataGridItem>
		<dg.dataGridItem field="note" width="140">Ghi chú</dg.dataGridItem>
		<dg.dataGridItem field="assignName" width="140">Phụ trách</dg.dataGridItem>
		<layout.toolbar id="dg_student_'.$this->id.'_toolbar">
			<hform id="dg_search_'.$this->id.'" onsubmit="pzk.elements.'.$this->id.'.searchStudent(); return false;">
				<strong>Tên học sinh: </strong><form.textField width="120px" name="name" id="searchName_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();" />
				<strong> SĐT: </strong><form.textField width="80px" name="phone" id="searchPhone_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();" />
				<edu.courseSelector id="searchClassIds_'.$this->id.'" 
						name="classIds" onChange="pzk.elements.'.$this->id.'.searchStudent();"
						defaultFilters=\''.@$this->defaultFilters.'\' />
				<form.combobox label="Chọn kỳ thanh toán" id="searchPeriod_'.$this->id.'" name="periodId"
					sql="'.$payment_period_sql.'" layout="category-select-list" onChange="pzk.elements.'.$this->id.'.searchStudent();"></form.combobox>
				<form.combobox label="Chọn kỳ chưa thanh toán" id="searchnotlikePeriod_'.$this->id.'" name="notlikeperiodId"
					sql="'.$payment_period_sql.'" layout="category-select-list" onChange="pzk.elements.'.$this->id.'.searchStudent();"></form.combobox>
				<select name="color" id="searchColor_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Chọn màu</option>
					<option value="red">Đỏ</option>
					<option value="blue">Xanh da trời</option>
					<option value="green">Xanh lá cây</option>
					<option value="yellow">Vàng</option>
					<option value="purple">Tím</option>
					<option value="grey">Xám</option>
				</select>
				<select name="fontStyle" id="searchFontStyle_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Chọn kiểu</option>
					<option value="bold">Đậm</option>
					<option value="italic">Nghiêng</option>
					<option value="underline">Gạch chân</option>
				</select>
				<form.combobox label="Người phụ trách" id="searchAssignId_'.$this->id.'" name="assignId"
					sql="'.$teacher_sql.'" onChange="pzk.elements.'.$this->id.'.searchStudent();"
					layout="category-select-list"></form.combobox>
				<select name="online" id="searchOnline_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Học tại</option>
					<option value="0">Trung tâm</option>
					<option value="1">Trực tuyến</option>
				</select>
				<select name="classed" id="searchClassed_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Xếp lớp</option>
					<option value="1">Đã xếp lớp</option>
					<option value="0">Chờ xếp lớp</option>
					<option value="-1">Thi đầu vào</option>
				</select>
				<select name="type" id="searchType_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Phân loại</option>
					<option value="1">Đang học</option>
					<option value="0">Tiềm năng</option>
					<option value="2">Lâu năm</option>
				</select>
				<select name="rating" id="searchRating_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Xếp hạng</option>
					<option value="0">Chưa xếp hạng</option>
					<option value="1">Kém</option>
					<option value="2">Trung Bình</option>
					<option value="3">Khá</option>
					<option value="4">Giỏi</option>
					<option value="5">Xuất Sắc</option>
				</select>
				<select name="status" id="searchStatus_'.$this->id.'" onChange="pzk.elements.'.$this->id.'.searchStudent();">
					<option value="">Trạng thái</option>
					<option value="0">Đang học</option>
					<option value="1">Dừng học</option>
				</select>
				<input type="submit" style="display: none;" value="Tìm" />
				<layout.toolbarItem id="searchButton_'.$this->id.'" action="$'.$this->id.'.searchStudent();" icon="search" />
				<layout.toolbarItem action="$dg_student_'.$this->id.'.detail(function(row) { 
					$'.$this->id.'.setValue(row.id);
					$'.$this->id.'.closeStudentSelectorDialog();
				});" icon="sum" />
			</hform>
		</layout.toolbar>
	</dg.dataGrid>
</wdw.dialog>
';

 }
}

<?php
class PzkEduCourseSelector extends PzkObject {
	public $layout = 'edu/course/selector';
	public $scriptable = true;
	public $value = null;
	public $onChange = null;
	public $name = null;
	public $rand = null;
	public $online = 0;
	public $defaultFilters = '{"online": 0}';
	public $height = '350px';
	public function init() {
		// Thêm grid
		$this->rand = rand(0, 1000000000);
		$dialog = $this->getDialog();
		pzk_element('left')->append($dialog);
	}
	public function getDialog() {
		$dialogHtml = $this->getDialogHtml();
		return pzk_parse($dialogHtml);
	}
	public function getDialogHtml() {
		require BASE_DIR . '/' . pzk_app()->getUri('constants.php');
		$rand = $this->rand;
  return '
<wdw.dialog id="dlg_course_'.$this->id.'" 
		width="1000px" height="auto" title="Khóa học"
		layout="easyui/window/dialog">
	<dg.dataGrid id="dg_course_'.$this->id.'" title="Quản lý lớp học" 
			scriptable="true" table="classes" 
			width="950px" height="'.$this->height.'" 
			rownumbers="false" pageSize="10" 
			defaultFilters=\''.$this->defaultFilters.'\'>
			<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
			<dg.dataGridItem field="name" width="120">Tên lớp</dg.dataGridItem>
			<dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
			<dg.dataGridItem field="level" width="120">Khối</dg.dataGridItem>
			<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
			<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
			<dg.dataGridItem field="roomName" width="100">Phòng</dg.dataGridItem>
			<dg.dataGridItem field="startDate" width="160">Ngày bắt đầu</dg.dataGridItem>
			<!--dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem-->
			<dg.dataGridItem field="amount" width="100">Học phí</dg.dataGridItem>
			<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
		<layout.toolbar id="dg_course_'.$this->id.'_toolbar">
			<hform id="dg_course_'.$this->id.'_search" onsubmit="pzk.elements.'.$this->id.'.searchCourse(); return false;">
				<form.combobox id="searchTeacher_'.$this->id.'" name="teacherId"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						sql="'.$teacher_sql.'"
						label="Chọn giáo viên"
						layout="category-select-list"></form.combobox>
				<form.combobox id="searchSubject_'.$this->id.'" name="subjectId"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						sql="'.$subject_sql.'"
						label="Chọn môn học"
						layout="category-select-list"></form.combobox>
				<form.combobox id="searchLevel_'.$this->id.'" name="level"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						sql="select distinct(level) as value, level as label from classes order by label asc"
						label="Chọn khối"
						layout="category-select-list"></form.combobox>
				<form.combobox name="status" id="searchStatus_'.$this->id.'"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						label="Trạng thái"
						layout="category-select-list">
					<option value="0">Dừng học</option>
					<option value="1">Đang học</option>
				</form.combobox>
				<form.combobox name="online" id="searchOnline_'.$this->id.'"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						label="Loại hình"
						layout="category-select-list">
					<option value="0">Trung tâm</option>
					<option value="1">Trực tuyến</option>
				</form.combobox>
				<form.combobox name="classed" id="searchClassed_'.$this->id.'"
						onChange="pzk.elements.'.$this->id.'.searchCourse();"
						label="Xếp lớp"
						layout="category-select-list">
					<option value="-1">Lớp chờ</option>
					<option value="1">Lớp học</option>
				</form.combobox>
				<layout.toolbarItem id="searchButton_'.$this->id.'" action="$'.$this->id.'.searchCourse();" icon="search" />
				<layout.toolbarItem action="$dg_course_'.$this->id.'.detail(function(row) { 
					$'.$this->id.'.setValue(row.id);
					$'.$this->id.'.closeCourseSelectorDialog();
				});" icon="sum" />
			</hform>
		</layout.toolbar>
	</dg.dataGrid>
</wdw.dialog>
';

 }
}

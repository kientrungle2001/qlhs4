<?php 
if(!isset($defaultFilters)):
	$defaultFilters = array('online' => 0, 'classed' => 1);
endif;	
	?>
<script>
classesDefaultAdd = <?php echo json_encode($defaultFilters);?>;
function course_dateInfo(value, item, index) {
	return [item.startDate, item.endDate].join('<br />');
}
function course_classInfo(value, item, index) {
	return [item.name, item.code].join('<br />');
}
function course_teachingInfo(value, item, index) {
	return [item.subjectName, 'Lớp ' + item.level, item.teacherName].join('<br />');
}
function course_learningInfo(value, item, index) {
	return [item.amount, item.status == '1' ? 'Đang học': 'Dừng học'].join('<br />');
}
</script>
<dg.dataGrid id="dg" title="Quản lý lớp học" scriptable="true" nowrap="false" 
		table="classes" width="500px" height="500px" rownumbers="false" pageSize="10" 
		defaultFilters='<?php echo json_encode($defaultFilters); ?>'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="160" formatter="course_classInfo">Tên lớp</dg.dataGridItem>
	<!--
	<dg.dataGridItem field="code" width="80">Mã</dg.dataGridItem>
	-->
	<dg.dataGridItem field="subjectName" width="120" formatter="course_teachingInfo">Giảng dạy</dg.dataGridItem>
	<!--dg.dataGridItem field="level" width="120">Trình độ</dg.dataGridItem-->
	<!--dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem-->
	<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
	<dg.dataGridItem field="roomName" width="60">Phòng</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="160" formatter="course_dateInfo">Khoảng thời gian</dg.dataGridItem>
	<!--
	<dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem>
	-->
	<dg.dataGridItem field="amount" width="100" formatter="course_learningInfo">Học phí</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.selectbox onChange="searchClasses()" 
					id="searchTeacher" name="teacherId"
					label="Chọn giáo viên"
					sql="select id as value, 
							name as label from `teacher` order by name ASC" />
			<form.selectbox onChange="searchClasses()" 
					id="searchSubject" name="subjectId"
					label="Chọn môn học"
					sql="{subject_center_sql}" />
			<form.selectbox onChange="searchClasses()" 
					id="searchLevel" name="level"
					label="Chọn khối"
					sql="select distinct(level) as value, level as label from classes order by label asc" />
			<form.selectbox onChange="searchClasses()"
					id="searchStatus" name="status"
					label="Chọn trạng thái">
						<option value="1">Đang học</option>
						<option value="0">Dừng học</option>
					</form.selectbox>
			<layout.toolbarItem action="searchClasses()" icon="search" />
			<layout.toolbarItem action="$dg.add(classesDefaultAdd)" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail(function(row) { 
				$dg_student.filters({
					classId: row.id
				});
				$dg_ontest.filters({
					classId: row.id
				});
			});" icon="sum" />
			<layout.toolbarItem action="$dg.doExport(); return false;" icon="redo" label="Export" />
		</hform>
		
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Lớp học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên lớp" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.combobox name="subjectId"
						sql="{subject_center_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="level" required="true" validatebox="true" label="Trình độ" />
			<frm.formItem type="user-defined" name="teacherId" required="false" label="Giáo viên">
				<form.combobox name="teacherId"
						sql="{teacher_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="teacher2Id" required="false" label="Giáo viên 2">
				<form.combobox name="teacher2Id"
						sql="{teacher_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="roomId" required="false" label="Phòng">
				<form.combobox name="roomId"
						sql="{room_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="online" required="false" label="Trực tuyến">
				<form.selectbox name="online">
					<option value="0">Trung tâm</option>
					<option value="1">Trực tuyến</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classed" required="false" label="Xếp lớp">
				<form.selectbox name="classed">
					<option value="1">Đã xếp lớp</option>
					<option value="-1">Chờ xếp lớp</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="startDate" type="date" required="false" label="Ngày bắt đầu">
			</frm.formItem>
			<frm.formItem name="endDate" type="date" required="false" label="Ngày kết thúc">
			</frm.formItem>
			<frm.formItem name="amount" required="false" label="Học phí">
			</frm.formItem>
			<frm.formItem type="user-defined" name="feeType" required="false" label="Loại phí">
				<form.selectbox name="feeType">
					<option value="0">Theo buổi</option>
					<option value="1">Cả khóa</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
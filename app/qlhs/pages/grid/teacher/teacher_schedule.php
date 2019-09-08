<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div>
	<div style="float: left; width: 400px;">
	<easyui.layout.panel collapsible="true" title="Thêm điểm danh" width="100%">
		<frm.form id="add_form">
				<frm.formItem type="hidden" name="id" label="" />
				<frm.formItem name="teacherId" label="Giáo viên" type="user-defined">
					<form.selectbox name="teacherId" label="Giáo viên" sql="{teacher_sql}" />
				</frm.formItem>
				<frm.formItem name="classId" label="Lớp" type="user-defined">
					<edu.courseSelector name="classId" label="Lớp" />
				</frm.formItem>
				<frm.formItem type="date" name="studyDate" label="Ngày bắt đầu" />
				<frm.formItem name="status" label="Trạng thái" type="user-defined">
					<select name="status">
						<option value="">Trạng thái</option>
						<option value="1">Có mặt</option>
						<option value="0">Vắng mặt</option>
					</select>
				</frm.formItem>
				<frm.formItem name="submit" label="" type="user-defined">
					<easyui.menu.linkbutton onClick="pzk.elements.dg.addMode().save('#add_form');return false;">Tạo điểm danh</easyui.menu.linkbutton>
			</frm.formItem>
		</frm.form>
	</easyui.layout.panel>
	<easyui.layout.panel collapsible="true" title="Tổng kết điểm danh" width="100%">
		<div id="teacher_muster_stat">
			<edu.teacher.musterstat  />
		</div>
	</easyui.layout.panel>
	</div>
	<div style="float: left; width: auto;">

<dg.dataGrid id="dg" title="Quản lý giảng dạy" scriptable="true" table="teacher_schedule" 
		width="800px" height="500px" rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="120">Ngày học</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="searchTeacherSchedule(); return false;">
			<form.selectbox label="Giáo viên" id="searchTeacherId" name="teacherId"
				sql="{teacher_sql}" onChange="searchTeacherSchedule();" />
			<edu.courseSelector label="Lớp" id="searchCourse" name="classId"
				onChange="searchTeacherSchedule();" />
		</hform>
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit(); $courseSelector.loadValue();" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Công việc">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" label="" />
			<frm.formItem name="teacherId" label="Giáo viên" type="user-defined">
				<form.selectbox name="teacherId" label="Giáo viên" sql="{teacher_sql}" />
			</frm.formItem>
			<frm.formItem name="classId" label="Lớp" type="user-defined">
				<edu.courseSelector id="courseSelector" name="classId" label="Lớp" />
			</frm.formItem>
			<frm.formItem type="date" name="studyDate" label="Ngày bắt đầu" />
			<frm.formItem name="status" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
	</div>
	<div style="clear:both;"></div>
<script>
function searchTeacherSchedule() {
	pzk.elements.dg.search({
		'fields': {
			'classId' : '#searchCourse',
			'teacherId' : '#searchTeacherId' 
		}
	});
	$.ajax({
		url: '{url /teacher/musterstat}',
		data: {
			classId: $('#searchCourse').pzkVal(),
			teacherId: $('#searchTeacherId').pzkVal()
		},
		success: function(musterstat) {
			$('#teacher_muster_stat').html(musterstat);
		}
	});
	
}
</script>
</div>
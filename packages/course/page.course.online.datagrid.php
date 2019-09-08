<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<dg.dataGrid id="dg" title="Quản lý lớp học" scriptable="true" table="classes" 
		width="500px" height="500px" rownumbers="false" pageSize="10" defaultFilters='{"online": 1}'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140">Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="140">Dịch vụ</dg.dataGridItem>
	<!--dg.dataGridItem field="level" width="120">Trình độ</dg.dataGridItem-->
	<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
	<!--dg.dataGridItem field="roomName" width="100">Phòng</dg.dataGridItem-->
	<dg.dataGridItem field="amount" width="80">Học phí</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.selectbox onChange="searchClasses()" 
					id="searchTeacher" name="teacherId"
					sql="{teacher_sql}" label="Chọn giáo viên" />
			<form.selectbox onChange="searchClasses()" 
					id="searchSubject" name="subjectId"
					sql="{subject_online_sql}" label="Chọn phần mềm" />
			<form.selectbox onChange="searchClasses()" 
					id="searchLevel" name="level"
					sql="select distinct(level) as value, level as label from classes order by label asc"
					label="Lớp" />
			<form.selectbox onChange="searchClasses()"
					id="searchStatus" name="status"
					label="Chọn trạng thái">
						<option value="1">Đang kích hoạt</option>
						<option value="0">Chưa kích hoạt</option>
					</form.selectbox>
			<layout.toolbarItem action="searchClasses()" icon="search" />
			<layout.toolbarItem action="$dg.add({online: 1})" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail(function(row) { 
				$dg_student.filters({classId: row.id});
				$dg_advice.filters({classId: row.id});
				$dg_problem.filters({classId: row.id});
			});" icon="sum" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Lớp học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên lớp" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.combobox name="subjectId"
						sql="select id as value, 
								name as label from `subject` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="level" required="true" validatebox="true" label="Trình độ" />
			<frm.formItem type="user-defined" name="teacherId" required="false" label="Giáo viên">
				<form.combobox name="teacherId"
						sql="select id as value, 
								name as label from `teacher` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="teacher2Id" required="false" label="Giáo viên 2">
				<form.combobox name="teacher2Id"
						sql="select id as value, 
								name as label from `teacher` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="roomId" required="false" label="Phòng">
				<form.combobox name="roomId"
						sql="select id as value, 
								name as label from `room` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="online" required="false" label="Trực tuyến">
				<select name="online">
					<option value="0">Trung tâm</option>
					<option value="1">Trực tuyến</option>
				</select>
			</frm.formItem>
			<frm.formItem name="startDate" type="date" required="false" label="Ngày bắt đầu">
			</frm.formItem>
			<frm.formItem name="endDate" type="date" required="false" label="Ngày kết thúc">
			</frm.formItem>
			<frm.formItem name="amount" required="false" label="Học phí">
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<dg.dataGrid id="dg" title="Quản lý lớp học" scriptable="true" table="classes" width="500px" height="500px" rownumbers="false" pageSize="50" defaultFilters='{"online": 0}'>
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="code" width="80">Mã</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
	<!--dg.dataGridItem field="level" width="120">Trình độ</dg.dataGridItem-->
	<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
	<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
	<dg.dataGridItem field="roomName" width="100">Phòng</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="160">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="100">Học phí</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.combobox 
					id="searchTeacher" name="teacherId"
					label="Chọn giáo viên"
					sql="select id as value, 
							name as label from `teacher` order by name ASC"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchSubject" name="subjectId"
					label="Chọn môn học"
					sql="select id as value, 
							name as label from `subject` order by name ASC"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchLevel" name="level"
					label="Chọn khối"
					sql="select distinct(level) as value, level as label from classes order by label asc"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchStatus" name="status"
					label="Chọn trạng thái"
					sql="select distinct(status) as value, status as label from classes order by label asc"
					layout="category-select-list"></form.combobox>
			<layout.toolbarItem action="searchClasses()" icon="search" />
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail(function(row) { 
				jQuery('#searchClass2').val(row.id); 
				$dg2.search({'fields': {'classId' : '#searchClass2' }});
				jQuery('#searchClass3').val(row.id); 
				$dg3.search({'fields': {'classId' : '#searchClass3' }});
				$dg_student.filters({
					classIds: row.id
				});
				$dg_student_order.filters({
					classId: row.id,
					periodId: jQuery('#searchStudentOrderPeriod').val()
				});
				$dg_test_class.filters({
					classId: row.id
				});
				$dg_test_student_mark.filters({
					classId: row.id,
					testId: jQuery('#searchTestStudentMarkTestId').val() 
				});
				$dg_class_teacher.filters({
					classId: row.id
				});
				$dg_student_schedule.filters({
					classId: row.id
				});
				$dg_teacher_schedule.filters({
					classId: row.id
				});
			}); showCalendar();" icon="sum" />
			<layout.toolbarItem action="$dg.doExport(); return false;" icon="redo" label="Export" />
			<layout.toolbarItem action="$dg.doImport(); return false;" icon="undo" label="Import" />
		</hform>
		
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Lớp học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên lớp" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
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
			<frm.formItem type="user-defined" name="feeType" required="false" label="Loại phí">
				<select name="feeType">
					<option value="0">Theo buổi</option>
					<option value="1">Cả khóa</option>
				</select>
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<dg.export id="export_dg" gridId="dg" table="classes" 
		width="700px" height="auto" 
		searchOptions="getCourseSearchOption" />
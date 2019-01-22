<dg.dataGrid id="dg_classes" title="Quản lý lớp học" scriptable="true" table="classes" width="800px" height="500px" rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
	<!--dg.dataGridItem field="level" width="120">Trình độ</dg.dataGridItem-->
	<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
	<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
	<dg.dataGridItem field="roomName" width="100">Phòng</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="160">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="100">Học phí</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
	
	<layout.toolbar id="dg_classes_toolbar">
		<hform id="dg_classes_search">
			<form.combobox label="Chọn giáo viên"
					id="searchTeacher" name="teacherId"
					sql="{teacher_sql}"
					layout="category-select-list" onChange="searchClasses()"></form.combobox>
			<form.combobox label="Chọn môn học"
					id="searchSubject" name="subjectId"
					sql="{subject_sql}"
					layout="category-select-list" onChange="searchClasses()"></form.combobox>
			<form.combobox label="Chọn khối"
					id="searchLevel" name="level"
					sql="select distinct(level) as value, level as label from classes order by label asc"
					layout="category-select-list" onChange="searchClasses()"></form.combobox>
			<form.combobox label="Chọn trạng thái"
					id="searchStatus" name="status"
					sql="select distinct(status) as value, status as label from classes order by label asc"
					layout="category-select-list" onChange="searchClasses()"></form.combobox>
			<layout.toolbarItem action="searchClasses()" icon="search" />
		</hform>
	</layout.toolbar>
</dg.dataGrid>

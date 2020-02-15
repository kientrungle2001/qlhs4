<dg.dataGrid id="dg_test_student_mark" title="Kết quả thi" 
		table="test_student_mark" width="550px" height="250px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="testName" width="120">Bài kiểm tra</dg.dataGridItem>
	<dg.dataGridItem field="mark" width="120">Điểm</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_test_student_mark_toolbar">
	<hform id="dg_test_student_mark_search" onsubmit="searchTestStudentMark(); return false;">
		<form.combobox label="Bài thi" id="searchTestStudentMarkTestId" name="testId"
			sql="{test_sql}" layout="category-select-list" onChange="searchTestStudentMark();"></form.combobox>
	</hform>
</layout.toolbar>
</dg.dataGrid>
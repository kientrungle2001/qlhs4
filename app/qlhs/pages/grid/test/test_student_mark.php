<dg.dataGrid id="dg_test_student_mark" title="Điểm thi" table="test_student_mark" width="800px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="testName" width="220">Bài thi</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="mark" width="120">Điểm thi</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_test_student_mark_toolbar">
		<layout.toolbarItem action="$dg_test_student_mark.add(); $studentSelector.resetValue();$courseSelector2.resetValue();" icon="add" />
		<layout.toolbarItem action="$dg_test_student_mark.edit(); $studentSelector.loadValue(); $courseSelector2.loadValue();" icon="edit" />
		<layout.toolbarItem action="$dg_test_student_mark.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_test_student_mark" width="700px" height="auto" title="Bài thi">
		<frm.form gridId="dg_test_student_mark">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem 
					type="user-defined"
					name="studentId" required="false" validatebox="false" label="Học sinh">
				<edu.studentSelector name="studentId" id="studentSelector" />
			</frm.formItem>
			<frm.formItem 
					type="user-defined"
					name="classId" required="true" validatebox="true" label="Khóa học">
				<edu.courseSelector name="classId" id="courseSelector2" />
			</frm.formItem>
			<frm.formItem type="text" name="mark" required="false" label="Điểm" />
			<frm.formItem 
				type="user-defined"
				name="status" required="true" validatebox="true" label="Trạng thái">
					<select id="cmbStatus" name="status">
						<option value="0">Trạng thái</option>
						<option value="1">Đã kích hoạt</option>
						<option value="0">Chưa kích hoạt</option>
					</select>
			</frm.formItem>
			
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>

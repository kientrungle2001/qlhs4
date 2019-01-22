<dg.dataGrid id="dg_test_class" title="Các lớp" table="test_class" width="800px" height="450px">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_test_class_toolbar">
		<layout.toolbarItem action="$dg_test_class.add(); $courseSelector.resetValue();" icon="add" />
		<layout.toolbarItem action="$dg_test_class.edit(); $courseSelector.loadValue();" icon="edit" />
		<layout.toolbarItem action="$dg_test_class.del()" icon="remove" />
		<layout.toolbarItem action="$dg_test_class.detail(function(row){
			searchStudentMark(row);
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg_test_class" width="700px" height="auto" title="Bài thi">
		<frm.form gridId="dg_test_class">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem 
				type="user-defined"
				name="testId" required="true" validatebox="true" label="Chọn bài thi">
					<form.combobox label="Chọn bài thi" name="testId" id="cmbTest2"
						sql="{test_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem 
					type="user-defined"
					name="classId" required="true" validatebox="true" label="Khóa học">
				<edu.courseSelector name="classId" id="courseSelector" />
			</frm.formItem>	
			<frm.formItem type="date" name="startDate" label="Ngày bắt đầu" value="{current_date}" />
			<frm.formItem type="date" name="endDate" label="Ngày kết thúc" />
			
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

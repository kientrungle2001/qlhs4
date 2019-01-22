<!-- Danh sách bài thi -->
<dg.dataGrid id="dg" title="Quản lý Bài thi" table="test" width="400px" nowrap="false" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="220" nowap="false">Bài thi</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120" nowap="false">Mã</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="100">Môn</dg.dataGridItem>
	<dg.dataGridItem field="level" width="40">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>

	<!-- Toolbar -->
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row){
			searchClassesByTest(row);
			searchStudentMark(row);
		});" icon="sum" />
	</layout.toolbar>
	<!-- Dialog thêm bài thi -->
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Bài thi">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên bài thi" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem name="level" required="true" validatebox="true" label="Lớp" />
			<frm.formItem 
				type="user-defined"
				name="subjectId" required="true" validatebox="true" label="Chọn Môn">
					<form.combobox label="Chọn Môn" name="subjectId"
						sql="{subject_sql}"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem 
				type="user-defined"
				name="status" required="true" validatebox="true" label="Trạng thái">
					<select id="cmbTestStatus" name="status">
						<option value="0">Trạng thái</option>
						<option value="1">Đã kích hoạt</option>
						<option value="0">Chưa kích hoạt</option>
					</select>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>

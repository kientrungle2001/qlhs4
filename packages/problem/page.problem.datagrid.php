<dg.dataGrid id="dg" title="Quản lý vụ việc" table="problem"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên kế hoạch</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Vụ việc">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="studentId" required="false" validatebox="false" label="Học viên" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên vụ việc" />
			<frm.formItem name="content" required="true" validatebox="true" label="Nội dung" />
			<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc" />
			<frm.formItem name="subjectId" required="false" validatebox="false" label="Phần mềm/môn học" />
			<frm.formItem name="classId" required="false" validatebox="false" label="Lớp/dịch vụ" />
			<frm.formItem name="teacherId" required="false" validatebox="false" label="Giáo viên" />
			<frm.formItem name="employeeId" required="false" validatebox="false" label="Nhân viên" />
			<frm.formItem name="status" label="Trạng thái" />

		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
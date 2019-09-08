<dg.dataGrid id="dg" title="Quản lý công việc" table="task"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên công việc</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Công việc">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" label="" />
			<frm.formItem name="planId" label="Kế hoạch" type="user-defined">
				<form.selectbox name="planId" label="Kế hoạch" sql="{plan_sql}" />
			</frm.formItem>
			<frm.formItem name="name" label="Công việc" />
			<frm.formItem name="code" label="Mã" />
			<frm.formItem type="date" name="startDate" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" label="Ngày kết thúc" />
			<frm.formItem name="goal" label="Mục tiêu" />
			<frm.formItem name="result" label="Kết quả" />
			<frm.formItem name="progress" label="Tiến độ" />
			<frm.formItem name="subjectId" label="Phần mềm" />
			<frm.formItem name="note" label="Ghi chú" />
			<frm.formItem name="departmentId" label="Phòng ban" />
			<frm.formItem name="employeeId" label="Nhân viên" />
			<frm.formItem name="teacherId" label="Giáo viên" />
			<frm.formItem name="status" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
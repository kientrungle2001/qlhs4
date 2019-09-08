<dg.dataGrid id="dg" title="Quản lý kế hoạch" table="plan"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên kế hoạch</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row){
			$dg_task.filters({
				planId: row.id
			});
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Kế hoạch">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên kế hoạch" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc" />
			<frm.formItem name="goal" required="true" validatebox="true" label="Mục tiêu" />
			<frm.formItem name="result" required="false" validatebox="false" label="Kết quả" />
			<frm.formItem name="progress" required="false" validatebox="false" label="Tiến độ" />
			<frm.formItem name="subjectId" required="false" validatebox="false" label="Phần mềm" />
			<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
			<frm.formItem name="status" label="Trạng thái" />

		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
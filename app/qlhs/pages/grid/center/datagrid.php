<dg.dataGrid id="dg" title="Quản lý Trung tâm" table="center"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên Trung tâm</dg.dataGridItem>
	<dg.dataGridItem field="code" width="120">Mã</dg.dataGridItem>
	<dg.dataGridItem field="address" width="120">Địa chỉ</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row){
			$dg_room.filters({
				centerId: row.id
			});
			$dg_classes.filters({
				centerId: row.id
			});
			$dg_asset.filters({
				centerId: row.id
			});
			$dg_schedule.filters({
				centerId: row.id
			});
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Trung tâm">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên trung tâm" />
			<frm.formItem name="code" required="true" validatebox="true" label="Mã" />
			<frm.formItem name="address" required="true" validatebox="true" label="Địa chỉ" />
			<frm.formItem type="user-defined" name="status" label="Trạng thái">
				<form.selectbox name="status" label="Trạng thái">
					<option value="0">Không hoạt động</option>
					<option value="1">Đang hoạt động</option>
				</form.selectbox>
			</frm.formItem>

		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
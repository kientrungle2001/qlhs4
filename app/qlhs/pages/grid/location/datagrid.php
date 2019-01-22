<dg.dataGrid id="dg" title="Quản lý tỉnh thành" table="location"
		<?php if(isset($defaultFilters)):?>
			defaultFilters='<?php echo json_encode($defaultFilters); ?>'
		<?php endif;?>
		width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên tỉnh thành</dg.dataGridItem>
	<dg.dataGridItem field="type" width="120">Loại</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Tỉnh thành">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tỉnh thành" />
			<frm.formItem name="type" required="true" validatebox="true" label="Loại" type="user-defined">
				<select name="type">
					<option value="province">Tỉnh thành</option>
					<option value="district">Quận huyện</option>
					<option value="school">Trường học</option>
				</select>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
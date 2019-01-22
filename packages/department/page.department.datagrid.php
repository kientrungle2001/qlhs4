<div>
<?php 
if(!isset($filters)) {
	$filters = array();
}
if(!isset($defaultAdd)) {
	$defaultAdd = array(
		'status' => 1
	);
}
?>
<script>
<![CDATA[
	var defaultFilters = <?php echo json_encode($filters); ?>;
	var defaultAdd = <?php echo json_encode($defaultAdd); ?>;
]]>
</script>

<dg.dataGrid id="dg" title="Quản lý phòng ban" 
		table="department" width="400px" height="450px"
		<?php if(isset($filters) && count($filters)): ?>
		defaultFilters='<?php echo json_encode($filters)?>'
		<?php endif;?>>
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên phòng ban</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80">Trạng thái</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add(defaultAdd)" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Phòng ban">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên phòng ban" />
			<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
				<select name="status">
					<option value="0">Không hoạt động</option>
					<option value="1">Hoạt động</option>
				</select>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
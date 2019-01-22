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

<dg.dataGrid id="dg" title="Quản lý tài sản" 
		table="asset_schedule" width="800px" height="450px"
		<?php if(isset($filters) && count($filters)): ?>
		defaultFilters='<?php echo json_encode($filters)?>'
		<?php endif;?>>
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên tài sản</dg.dataGridItem>
	<dg.dataGridItem field="softwareName" width="120">Phần mềm</dg.dataGridItem>
	<dg.dataGridItem field="price" width="80">Giá trị</dg.dataGridItem>
	<dg.dataGridItem field="quantity" width="80">Số lượng</dg.dataGridItem>
	<dg.dataGridItem field="startStatus" width="80">Trạng thái lúc bàn giao</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80">Trạng thái</dg.dataGridItem>
	<dg.dataGridItem field="employeeName" width="80">Nhân viên</dg.dataGridItem>
	<dg.dataGridItem field="teacherName" width="80">Giáo viên</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="80">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="80">Ngày kết thúc</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add(defaultAdd)" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Tài sản">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="assetId" required="false" label="Tài sản">
				<form.combobox name="assetId" label="Tài sản"
						sql="{asset_sql}" layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="quantity" required="false" label="Số lượng" />
			<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc" />
			<frm.formItem type="user-defined" name="teacherId" required="false" label="Giáo viên">
				<form.combobox name="teacherId" label="Bàn giao cho giáo viên"
						sql="{teacher_sql}" layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="employeeId" required="false" label="Nhân viên">
				<form.combobox name="employeeId" label="Bàn giao cho nhân viên"
						sql="{employee_sql}" layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="roomId" required="false" label="Phòng học">
				<form.combobox name="roomId" label="Phòng học"
						sql="{room_sql}" layout="category-select-list"></form.combobox>
			</frm.formItem>
			
			<frm.formItem name="note" required="false" label="Ghi chú" />
			<frm.formItem type="user-defined" name="startStatus" required="false" label="Tình trạng lúc bàn giao">
				<select name="startStatus">
					<option value="0">Không sẵn có</option>
					<option value="1">Sẵn có</option>
					<option value="-1">Đang sửa</option>
				</select>
			</frm.formItem>
			<frm.formItem type="user-defined" name="status" required="false" label="Tình trạng">
				<select name="status">
					<option value="0">Không sẵn có</option>
					<option value="1">Sẵn có</option>
					<option value="-1">Đang sửa</option>
				</select>
			</frm.formItem>
			
			<frm.formItem name="userNote" required="false" label="Ghi chú của người được bàn giao" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
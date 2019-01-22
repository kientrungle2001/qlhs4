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
		table="asset" width="400px" height="450px"
		<?php if(isset($filters) && count($filters)): ?>
		defaultFilters='<?php echo json_encode($filters)?>'
		<?php endif;?>>
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên tài sản</dg.dataGridItem>
	<dg.dataGridItem field="price" width="80">Giá trị</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80">Trạng thái</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add(defaultAdd)" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Tài sản">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên tài sản" />
			<frm.formItem name="price" required="false" label="Giá trị" />
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
			<frm.formItem type="user-defined" name="online" required="false" label="Loại hình">
				<select name="online">
					<option value="0">Phương tiện - tài sản</option>
					<option value="1">Trực tuyến</option>
					<option value="2">Tài liệu</option>
				</select>
			</frm.formItem>
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Phần mềm">
			<form.combobox name="subjectId" label="Phần mềm"
						sql="{subject_online_sql}" layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="note" required="false" label="Ghi chú" />
			<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
				<select name="status">
					<option value="0">Không sẵn có</option>
					<option value="1">Sẵn có</option>
					<option value="-1">Đang sửa</option>
				</select>
			</frm.formItem>
			<frm.formItem type="user-defined" name="unlimited" required="false" label="Không giới hạn số lượng">
				<select name="unlimited">
					<option value="0">Giới hạn</option>
					<option value="1">Không giới hạn</option>
				</select>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
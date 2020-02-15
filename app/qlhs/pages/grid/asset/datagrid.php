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
	function asset_status(value, row, index) {
		switch(value) {
			case '0': return 'Không sẵn có';
			case '1': return 'Sẵn có';
			case '-1': return 'Đang sửa';
		}
	}
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
	<dg.dataGridItem field="status" width="80" formatter="asset_status">Trạng thái</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add(defaultAdd)" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="$dg.detail(function(row) {
			$dg_schedule.filters({
				assetId: row.id
			});
		})" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Tài sản">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên tài sản" />
			<frm.formItem name="price" label="Giá trị" />
			<frm.formItem name="quantity" label="Số lượng" />
			<frm.formItem type="date" name="startDate" label="Ngày bắt đầu" />
			<frm.formItem type="date" name="endDate" label="Ngày kết thúc" />
			<frm.formItem type="user-defined" name="teacherId" label="Giáo viên">
				<form.selectbox name="teacherId" label="Bàn giao cho giáo viên"
						sql="{teacher_sql}"></form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="employeeId" label="Nhân viên">
				<form.selectbox name="employeeId" label="Bàn giao cho nhân viên"
						sql="{employee_sql}"></form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="roomId" label="Phòng học">
				<form.selectbox name="roomId" label="Phòng học"
						sql="{room_sql}"></form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="online" label="Loại hình">
				<form.selectbox name="online">
					<option value="0">Phương tiện - tài sản</option>
					<option value="1">Trực tuyến</option>
					<option value="2">Tài liệu</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="subjectId" label="Phần mềm">
			<form.selectbox name="subjectId" label="Phần mềm"
						sql="{subject_online_sql}"></form.selectbox>
			</frm.formItem>
			<frm.formItem name="note" label="Ghi chú" />
			<frm.formItem type="user-defined" name="status" label="Trạng thái">
				<form.selectbox name="status">
					<option value="0">Không sẵn có</option>
					<option value="1">Sẵn có</option>
					<option value="-1">Đang sửa</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="unlimited" label="Không giới hạn số lượng">
				<form.selectbox name="unlimited">
					<option value="0">Giới hạn</option>
					<option value="1">Không giới hạn</option>
				</form.selectbox>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
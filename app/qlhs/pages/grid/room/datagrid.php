<div>
<dg.dataGrid id="dg" title="Quản lý phòng học" table="room" width="400px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên phòng</dg.dataGridItem>
	<dg.dataGridItem field="size" width="80">Cỡ</dg.dataGridItem>
	<dg.dataGridItem field="centerName" width="120">Trung tâm</dg.dataGridItem>
	<dg.dataGridItem field="note" width="180">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80" formatter="room_status">Trạng thái</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
		<layout.toolbarItem action="searchClasses(); searchAsset(); searchRoom(); showCalendar();" icon="sum" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Phòng học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên phòng" />
			<frm.formItem name="size" required="false" label="Cỡ" />
			<frm.formItem type="user-defined" name="centerId" required="false" label="Trung tâm">
				<form.selectbox name="centerId" sql="{center_sql}" />
			</frm.formItem>
			<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
				<form.selectbox name="status">
					<option value="0">Không sẵn có</option>
					<option value="1">Sẵn có</option>
					<option value="-1">Đang sửa</option>
				</form.selectbox>
			</frm.formItem>
			<frm.formItem name="note" required="false" label="Ghi chú" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<script>
	function room_status(value, item, index) {
		if(value == '-1') {
			return 'Đang sửa';
		}
		if(value == '1') {
			return 'Sẵn có';
		}
		if(value == '0') {
			return 'Không sẵn có';
		}
	}
</script>
</div>
<dg.dataGrid id="dg" title="Quản lý quyền người dùng" table="profile_controller_permission" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="type" width="120">Quyền</dg.dataGridItem>
	<dg.dataGridItem field="controller" width="120">Controller</dg.dataGridItem>
	<dg.dataGridItem field="action" width="120">Action</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">Status</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Người dùng">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" label="Loại người dùng">
				<select name="type">
					<option value="Administrator">Quản trị</option>
					<option value="Cashier">Thu ngân</option>
					<option value="Accountant">Kế toán</option>
					<option value="Guest">Khách</option>
				</select>
			</frm.formItem>
			<frm.formItem name="controller" required="true" validatebox="true" label="Controller" />
			<frm.formItem name="action" required="true" validatebox="true" label="Action" />
			<frm.formItem name="status" required="true" validatebox="true" label="Status" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
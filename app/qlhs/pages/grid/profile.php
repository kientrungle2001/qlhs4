<dg.dataGrid id="dg" title="Quản lý người dùng" table="profile_profile" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="username" width="120">Tên đăng nhập</dg.dataGridItem>
	<dg.dataGridItem field="type" width="120">Quyền</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Người dùng">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="username" required="true" validatebox="true" label="Tên đăng nhập" />
			<frm.formItem name="password" required="true" validatebox="true" label="Mật khẩu" />
			<frm.formItem type="user-defined" label="Loại người dùng">
				<form.combobox name="type"
						sql="select name as value, 
								name as label from `profile_type` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
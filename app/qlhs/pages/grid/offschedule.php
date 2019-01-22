<dg.dataGrid id="dg" title="Quản lý lịch nghỉ" table="off_schedule" width="800px" height="450px" singleSelect="true">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="type" width="100">Loại nghỉ</dg.dataGridItem>
	<dg.dataGridItem field="paymentType" width="100">Loại trừ tiền</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="offDate" width="160">Ngày nghỉ</dg.dataGridItem>
	<dg.dataGridItem field="reason" width="160">Lý do</dg.dataGridItem>
	
	
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.combobox 
					id="searchClass" name="classId"
					sql="select id as value, 
							name as label from `classes` where status=1 order by name ASC"
					layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="$dg.search({'fields': {'classId' : '#searchClass' }})" icon="search" />
				<layout.toolbarItem action="$dg.add()" icon="add" />
				<layout.toolbarItem action="$dg.edit()" icon="edit" />
				<layout.toolbarItem action="$dg.del()" icon="remove" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Lớp học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" required="true" validatebox="true" label="Loại">
				<select name="type">
					<option value="center">Trung tâm</option>
					<option value="class">Lớp</option>
				</select>
			</frm.formItem>
			<frm.formItem type="user-defined" required="true" validatebox="true" label="Loại">
				<select name="paymentType">
					<option value="immediate">Trừ luôn</option>
					<option value="later">Trừ sang tháng sau</option>
				</select>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="date" name="offDate" required="true" label="Ngày nghỉ" />
			<frm.formItem name="reason" required="true" validatebox="true" label="Lý do" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
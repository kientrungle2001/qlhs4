<dg.dataGrid id="dg" title="Quản lý lịch học" table="schedule" width="800px" height="450px" singleSelect="false">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="160">Ngày học</dg.dataGridItem>
	<dg.dataGridItem field="studyTime" width="160">Giờ học</dg.dataGridItem>
	<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem>
	
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
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="date" name="studyDate" required="false" label="Ngày học">
			</frm.formItem>
			<frm.formItem type="time" name="studyTime" required="false" label="Giờ học">
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
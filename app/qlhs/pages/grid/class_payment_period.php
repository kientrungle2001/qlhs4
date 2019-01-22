<dg.dataGrid id="dg" title="Ky thanh toan theo lop" scriptable="true" table="class_payment_period" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="periodName" width="120">Ky thanh toan</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.combobox id="searchClass" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="$dg.search({'fields': {'classId' : '#searchClass' }})" icon="search" />
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Ky thanh toan theo lop">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="payment_periodId" required="true" validatebox="true" label="Học sinh">
				<form.combobox name="payment_periodId"
						sql="select id as value, 
								name as label from `payment_period` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
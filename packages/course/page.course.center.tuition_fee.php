<dg.dataGrid id="dg3" title="Quản lý học phí" table="tuition_fee" 
		width="310px" height="350px" singleSelect="false" noClickRow="true"  rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="periodName" width="180">Kỳ thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="120">Số tiền</dg.dataGridItem>
	<!--dg.dataGridItem field="studyTime" width="160">Giờ học</dg.dataGridItem>
	<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem-->
	
	<layout.toolbar id="dg3_toolbar">
		<hform id="dg3_search">
			<form.combobox 
					id="searchClass3" name="classId"
					sql="select id as value, 
							name as label from `classes` where status=1 order by name ASC"
					layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="$dg3.search({'fields': {'classId' : '#searchClass3' }})" icon="search" />
				<layout.toolbarItem action="$dg3.add({classId: $dg.getSelected('id')})" icon="add" />
				<layout.toolbarItem action="$dg3.edit()" icon="edit" />
				<layout.toolbarItem action="$dg3.del()" icon="remove" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg3" width="700px" height="auto" title="Học phí">
		<frm.form gridId="dg3">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="periodId" required="false" label="Kỳ thanh toán">
				<form.combobox name="periodId"
						sql="select id as value, 
								name as label from `payment_period` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="amount" required="false" label="Học phí">
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
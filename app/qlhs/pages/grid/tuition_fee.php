<dg.dataGrid id="dg" title="Quản lý Học phí" table="payment_period" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Kỳ thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="status" width="120">Trạng thái</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Kỳ thanh toán">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Kỳ thanh toán" />
			<frm.formItem type="user-defined" name="classId" required="false" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="date" name="startDate" required="false" label="Ngày bắt đầu">
			</frm.formItem>
			<frm.formItem type="date" name="endDate" required="false" label="Ngày kết thúc">
			</frm.formItem>
			<frm.formItem name="status" required="false" validatebox="false" label="Trạng thái" value="1" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
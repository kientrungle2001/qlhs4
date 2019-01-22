<dg.dataGrid id="dg_student_order" title="Danh sách học phí" scriptable="true" 
		layout="easyui/datagrid/datagrid" 
		nowrap="true" pageSize="50"
		table="student_order" width="550px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
	<dg.dataGridItem field="periodName" width="120">Kỳ thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="120">Số tiền</dg.dataGridItem>
	<dg.dataGridItem field="created" width="120">Ngày thanh toán</dg.dataGridItem>
	
	<layout.toolbar id="dg_student_order_toolbar">
		<hform id="dg_student_order_search" onsubmit="searchStudentOrder(); return false;">
			<form.combobox label="Chọn kỳ thanh toán" id="searchStudentOrderPeriod" name="periodId"
				sql="{payment_period_sql}" layout="category-select-list" onChange="searchStudentOrder();"></form.combobox>
		</hform>
	</layout.toolbar>
</dg.dataGrid>
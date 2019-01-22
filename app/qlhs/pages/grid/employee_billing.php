<div>
<dg.dataGrid id="dg" title="Danh sách hóa đơn" scriptable="true" 
		table="billing_order" width="800px" height="450px"
		defaultFilters='{"partyType": "employee"}'
		>
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Họ và tên</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="address" width="80">Địa chỉ</dg.dataGridItem>
	<dg.dataGridItem field="reason" width="160">Lý do</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="80">Số tiền</dg.dataGridItem>
	<dg.dataGridItem field="orderType" width="80" formatter="orderTypeFormatter">Loại HĐ</dg.dataGridItem>
	<dg.dataGridItem field="type" width="80" formatter="typeFormatter">Loại</dg.dataGridItem>
	<dg.dataGridItem field="created" width="80">Ngày tạo</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<layout.toolbarItem action="$dg.detail({url: '{url /order/billingdetail}', 'gridField': 'id', 'action': 'view', 'renderRegion': '#order-detail'});" icon="sum" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
		</hform>
	</layout.toolbar>
</dg.dataGrid>
<div id="order-detail"></div>
<script>
function typeFormatter(value, row, index) {
	if(value === 'normal') return 'Một mục';
	return 'Nhiều mục';
}
function orderTypeFormatter(value, row, index) {
	if(value==='billing') {
		return 'HĐ Chi';
	}
	return 'HĐ Thu';
}
</script>
</div>
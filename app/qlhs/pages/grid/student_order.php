<div>
<dg.dataGrid id="dg" title="Danh sách hóa đơn" scriptable="true" table="general_order" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên học sinh</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="address" width="80">Địa chỉ</dg.dataGridItem>
	<dg.dataGridItem field="reason" width="160">Lý do</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="80">Số tiền</dg.dataGridItem>
	<dg.dataGridItem field="created" width="80">Ngày tạo</dg.dataGridItem>
	<dg.dataGridItem field="bookNum" width="40">Quyển</dg.dataGridItem>
	<dg.dataGridItem field="noNum" width="40">Số</dg.dataGridItem>
	<dg.dataGridItem field="status" width="80">Trạng thái</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="searchOrder(); return false;">
			<strong>Tên học sinh: </strong><form.textField name="name" id="searchName" />
			<strong> SĐT: </strong><form.textField name="phone"  id="searchPhone"/>
			<input type="submit" style="display: none;" value="Tìm" />
			<layout.toolbarItem action="if(window.viewMode == true) $dg.detail({url: '{url /order/detail}', 'gridField': 'id', 'action': 'view', 'renderRegion': '#order-detail'});" icon="sum" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<a id="changeMode" href="javascript:window.viewMode = !window.viewMode; if(window.viewMode) {jQuery('#changeMode').text('Chế độ xem');} else {jQuery('#changeMode').text('Chế độ chọn');}">Chế độ xem</a>
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Hóa đơn">
		<frm.form gridId="dg"> 
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="studentId" required="true" validatebox="true" label="Học sinh">
				<form.combobox name="studentId"
						sql="select id as value, 
								name as label from `student` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="payment_periodId" required="true" validatebox="true" label="Kỳ thanh toán">
				<form.combobox name="payment_periodId"
						sql="select id as value, 
								name as label from `payment_period` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="text" name="amount" required="false" label="Số tiền" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
<div id="order-detail"></div>
<script>
function searchOrder() {
	pzk.elements.dg.search({
		'fields': {
			'name' : '#searchName', 
			'phone': '#searchPhone'
		}
	});
}
window.viewMode = true;
</script>
</div>

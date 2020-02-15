<style>
.row.no-gutters {
	margin-right: 0;
	margin-left: 0;
}
.row.no-gutters > [class^="col-"],
.row.no-gutters > [class*=" col-"] {
	padding-right: 0;
	padding-left: 0;
}
.table-reduce-font {
	font-size: 0.8rem;
}
</style>
<script>
	loginId = <?php echo pzk_session('loginId');?>;
	usertype = <?php echo pzk_session('usertype');?>;
</script>
<div class="row no-gutters mt-3 table-reduce-font" ng-app="erpApp" ng-controller="thamsoController">
	<div class="col-md-3">
		<div class="card">
			<div class="card-header bg-primary text-white">Bộ lọc</div>
			<div class="card-body">
				<form onsubmit="return false;">
					<div class="form-group">
							<label for="keyword">Tìm kiếm:</label>
							<input class="form-control form-control-sm" id="keyword" ng-model="keyword" ng-change="search()" />
					</div>

					<div class="form-group">
						<select id="type" ng-model="selectedType" ng-change="chonType()" 
								class="form-control form-control-sm"
								ng-options="type as type for type in types">
							<option value="">Chọn Loại Tham số</option>
						</select>
					</div>
					<div class="form-group">
						<select ng-model="STATUS" ng-change="chonStatus()" class="form-control form-control-sm">
							<option value="">Trạng thái</option>
							<option value="0">Chưa kích hoạt</option>
							<option value="1">Đã kích hoạt</option>
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header bg-primary text-white">Danh sách tham số</div>
			<div class="mt-2 mb-2 pl-2 pr-2">
				<select ng-model="rows" ng-options="rows_item as rows_item for rows_item in all_rows" ng-change="reload()" class="btn btn-primary">
				</select>
				<a class="btn btn-sm mr-1" ng-repeat="p in pages()" ng-click="changePage(p)" ng-class="{'btn-primary text-white': page==p, 'btn-secondary text-white': page!=p}"><% p %></a>
				<button class="btn btn-primary btn-sm" ng-click="add()">Thêm mới</button>
				<button class="btn btn-danger btn-sm" ng-click="del()">Xóa</button>
			</div>
			<table class="table table-striped table-condensed table-bordered table-sm" ng-show="mode=='list'">
				<thead>
					<tr>
						<th><input type="checkbox" ng-model="checkAllItems" ng-change="toggleSelectedItems()" /></th>
						<th>ID</th>
						<th>Loại tham số</th>
						<th>Giá trị</th>
						<th>Nhãn</th>
						<th>Mô tả</th>
						<th>Thứ tự</th>
						<th>Trạng thái</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in items" ng-click="itemSelecteds[item.id] = !itemSelecteds[item.id]">
						<td><input type="checkbox" ng-model="itemSelecteds[item.id]" /></td>
						<td><% item.id%></td>
						<td><% item.PAR_TYPE%></td>
						<td><% item.PAR_CODE%></td>
						<td><% item.PAR_NAME%></td>
						<td><% item.DESCRIPTION%></td>
						<td><% item.PAR_ORDER%></td>
						<td><% item.STATUS | status%></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
</div>
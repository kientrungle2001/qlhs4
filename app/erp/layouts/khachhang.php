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
<div class="row no-gutters mt-3 table-reduce-font" ng-app="erpApp" ng-controller="khachhangController">
	<div class="col-md-2">
		<div class="card">
			<div class="card-header bg-primary text-white">Bộ lọc</div>
			<div class="card-body">
				<form onsubmit="return false;">
					<!-- Tìm kiếm -->
					<div class="form-group">
							<!--label for="keyword">Tìm kiếm:</label-->
							<input placeholder="Tìm kiếm" class="form-control form-control-sm" id="keyword" ng-model="keyword" ng-change="search()" />
					</div>

					<!-- Ngày bắt đầu -->
					<div class="form-group">
							<!--label for="ngayBatDau">Ngày bắt đầu:</label-->
							<input placeholder="Ngày bắt đầu" jqdatepicker class="form-control form-control-sm" id="ngayBatDau" ng-model="ngayBatDau" ng-change="chonNgayBatDau()" />
					</div>

					<!-- Ngày kết thúc -->
					<div class="form-group">
							<!--label for="ngayKetThuc">Ngày kết thúc:</label-->
							<input placeholder="Ngày kết thúc" jqdatepicker class="form-control form-control-sm" id="ngayKetThuc" ng-model="ngayKetThuc" ng-change="chonNgayKetThuc()" />
					</div>

					<!-- Lọc Nhân viên kinh doanh -->
					<div class="form-group">
						<select id="nhan_vien_kinh_doanh" ng-model="selectedSale" ng-change="selectSaleStaff()" 
								class="form-control form-control-sm"
								ng-options="sale as (sale.CODE + ' - ' + sale.NAME) for sale in saleStaffs track by sale.id">
							<option value="">Chọn NVKD</option>
						</select>
					</div>

					<!-- Lọc theo Nhà cung cấp -->
					<div class="form-group">
						<select id="nha_cc" ng-model="selectedProvider" ng-change="selectProvider()" 
								class="form-control form-control-sm"
								ng-options="provider.PAR_CODE as provider.PAR_NAME for provider in providers track by provider.PAR_CODE">
							<option value="">Chọn Nhà cung cấp</option>
						</select>
					</div>
					<!-- Lọc theo trạng thái hóa đơn THAP -->
					<div class="form-group">
						<select ng-model="tinh_trang" ng-change="chonTinhTrang()" class="form-control form-control-sm">
							<option value="">Trạng thái</option>
							<option value="new">Mới</option>
							<option value="processing">Điều phối viên đang xử lý</option>
							<option value="provider">Đang chuyển sang nhà cung cấp</option>
							<option value="provider-processed">Nhà cung cấp đã xử lý</option>
							<option value="technical">Đang chuyển cho phòng kỹ thuật</option>
							<option value="technical-processed">Phòng kỹ thuật</option>
							<option value="shipping">Đang chuyển cho bộ phận giao vận</option>
							<option value="shipped">Đã giao</option>
							<option value="completed">Đã xong</option>
						</select>
					</div>

					<div class="form-group">
						<select ng-model="spam_tinh_luong" ng-change="chonSpamTinhLuong()" class="form-control form-control-sm">
							<option value="">Spam tính lương</option>
							<option value="yes">Có</option>
							<option value="no">Không</option>
						</select>
					</div>

					<div class="form-group">
						<select ng-model="co_hoa_don" ng-change="chonCoHoaDon()" class="form-control form-control-sm">
							<option value="">Có hóa đơn</option>
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>
					</div>

					<div class="form-group">
						<select ng-model="co_thiet_bi" ng-change="chonCoThietBi()" class="form-control form-control-sm">
							<option value="">Có thiết bị</option>
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>
					</div>

					<div class="form-group">
						<select ng-model="ngay_vang" ng-change="chonNgayVang()" class="form-control form-control-sm">
							<option value="">Ngày vàng</option>
							<option value="0">Không có</option>
							<option value="1.5">Nhân 1.5</option>
							<option value="2">Nhân 2</option>
						</select>
					</div>

					<div class="form-group">
						<select ng-model="giao_phat" ng-change="chonGiaoPhat()" class="form-control form-control-sm">
							<option value="">Giao phát</option>
							<option value="NO">Không có</option>
							<option value="COD">COD - Thu tiền hộ</option>
							<option value="IMS">IMS - Chuyển phát nhanh</option>
							<option value="KTT">KTT - Kỹ thuật trả</option>
						</select>
					</div>


					<!-- Sắp xếp theo -->
					<div class="form-group">
						<select ng-model="truong_sap_xep" ng-change="chonTruongSapXep()" class="form-control form-control-sm">
							<option value="id">Sắp xếp theo</option>
							<option value="id">ID</option>
							<option value="ngay_gui_yc">Ngày gửi yêu cầu</option>
							<option value="ngay_nhan">Ngày nhận</option>
							<option value="nha_cc">Nhà cung cấp</option>
							<option value="nhan_vien_kinh_doanh">Nhân viên kinh doanh</option>
						</select>
					</div>

					<!-- Thứ tự -->
					<div class="form-group">
						<select ng-model="thu_tu_sap_xep" ng-change="chonThuTuSapXep()" class="form-control form-control-sm">
							<option value="asc">Thứ tự</option>
							<option value="asc">Tăng</option>
							<option value="desc">Giảm</option>
						</select>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="card-header bg-primary text-white">Danh sách THAP</div>
			<div class="mt-2 mb-2 pl-2 pr-2">
			<select ng-model="rows" ng-options="rows_item as rows_item for rows_item in all_rows" ng-change="reload()" class="btn btn-primary btn-sm">
			</select>
			<a class="btn btn-sm" ng-repeat="p in pages()" ng-click="changePage(p)" ng-class="{'btn-primary text-white': page==p, 'btn-secondary text-white': page!=p}"><% p %></a>
			<button class="btn btn-primary btn-sm" ng-click="mode='addmul'">Thêm nhiều</button>
			<button class="btn btn-primary btn-sm" ng-click="add()">Thêm mới</button>
			<button class="btn btn-primary btn-sm" ng-click="export('xlsx', 'default')">Xuất dữ liệu</button>
			<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal">Nhập dữ liệu</button>
			<button class="btn btn-danger btn-sm" ng-click="del()">Xóa</button>
			</div>
			<table class="table table-striped table-condensed table-bordered table-sm" ng-show="mode=='list'">
				<thead>
					<tr>
						<th><input type="checkbox" ng-model="checkAllItems" ng-change="toggleSelectedItems()" /></th>
						<th>ID</th>
						<th>Số tài khoản</th>
						<th>Địa chỉ</th>
						<th>Đại lý</th>
						<th>Tên ngân hàng</th>
						<th>Loại khách hàng</th>
						<th>Địa chỉ triển khai</th>
						<th>Mô tả</th>
						<th>Email</th>
						<th>Fax</th>
						<th>Tên khách hàng</th>
						<th>Công ty</th>
						<th>Địa chỉ công ty</th>
						<th>Tỉnh thành</th>
						<th>Người đại diện</th>
						<th>Nhân viên kinh doanh</th>
						<th>Trạng thái</th>
						<th>Cơ quan thuế</th>
						<th>Mã số thuế</th>
						<th>Cục thuế</th>
						<th>Số điện thoại</th>
						<th>Ngày đăng ký</th>
						<th>Ngày tải lên cuối cùng</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in items" ng-click="itemSelecteds[item.id] = !itemSelecteds[item.id]">
						<td><input type="checkbox" ng-model="itemSelecteds[item.id]" /></td>
						<td><% item.id%></td>
						<td><% item.ACCOUNT_NO%></td>
						<td><% item.ADDRESS%></td>
						<td><% item.AGENCY%></td>
						<td><% item.BANK_NAME%></td>
						<td><% item.CUST_TYPE%></td>
						<td><% item.DEPLOY_ADDRESS%></td>
						<td><% item.DESCRIPTION%></td>
						<td><% item.EMAIL%></td>
						<td><% item.FAX%></td>
						<td><% item.MINE_NAME%></td>
						<td><% item.NAME%></td>
						<td><% item.OFFICE_ADDRESS%></td>
						<td><% item.PROVINCE_NAME%></td>
						<td><% item.REPRESENTATIVE_NAME%></td>
						<td><% item.STAFF_NAME%></td>
						<td><% item.STATUS%></td>
						<td><% item.TAX_AUTHORITY%></td>
						<td><% item.TAX_CODE%></td>
						<td><% item.TAX_DEPARTMENT%></td>
						<td><% item.TEL_NUMBER%></td>
						<td><% item.DATE_REGISTER%></td>
						<td><% item.LAST_UPLOAD_DATE%></td>
					</tr>
				</tbody>
			</table>
			
			<div class="card-body" ng-show="mode=='edit' || mode=='add'">
			<h5 class="card-title">Chi tiết</h5>
			<button href="javascript:void(0)" ng-click="save()" class="btn btn-primary">Lưu</button>
				<button href="javascript:void(0)" ng-click="resetAdd()" class="btn btn-secondary" ng-show="mode=='add'">Clear</button>
				<button href="javascript:void(0)" ng-click="cancel()" class="btn btn-secondary">Quay lại</button>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin khách hàng</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin công ty</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin thuế</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Ngày trả</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kinh doanh</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nhà cung cấp</h6>
				<p class="card-text">
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kỹ thuật</h6>
				<p class="card-text">
				</p>
				<h6>Spam tính lương</h6>
				<p class="card-text">
				</p>
				<button href="javascript:void(0)" ng-click="save()" class="btn btn-primary">Lưu</button>
				<button href="javascript:void(0)" ng-click="resetAdd()" class="btn btn-secondary" ng-show="mode=='add'">Clear</button>
				<button href="javascript:void(0)" ng-click="cancel()" class="btn btn-secondary">Quay lại</button>
			</div>

			<div class="card-body" ng-show="mode=='addmul'">
				<table class="table table-sm" style="width: 6000px;">
					<tr>
						<th>&nbsp;</th>
						<th>Số tài khoản</th>
						<th>Địa chỉ</th>
						<th>Đại lý</th>
						<th>Tên ngân hàng</th>
						<th>Loại khách hàng</th>
						<th>Địa chỉ triển khai</th>
						<th>Mô tả</th>
						<th>Email</th>
						<th>Fax</th>
						<th>Tên khách hàng</th>
						<th>Công ty</th>
						<th>Địa chỉ công ty</th>
						<th>Tỉnh thành</th>
						<th>Người đại diện</th>
						<th>Nhân viên kinh doanh</th>
						<th>Trạng thái</th>
						<th>Cơ quan thuế</th>
						<th>Mã số thuế</th>
						<th>Cục thuế</th>
						<th>Số điện thoại</th>
						<th>Ngày đăng ký</th>
						<th>Ngày tải lên cuối cùng</th>
						<th>&nbsp;</th>
					</tr>
					<tr ng-repeat="item in multipleItems">
						<td>
							<a href="#" ng-click="addMulItem()"><span class="fa fa-plus-square-o"></span></a>
							<a href="#" ng-click="removeMulItem($index)"><span class="fa fa-remove text-danger"></span></a>
						</td>
						<td><input class="form-control form-control-sm" ng-model="item.ACCOUNT_NO" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.ADDRESS" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.AGENCY" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.BANK_NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.CUST_TYPE" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.DEPLOY_ADDRESS" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.DESCRIPTION" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.EMAIL" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.FAX" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.MINE_NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.OFFICE_ADDRESS" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.PROVINCE_NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.REPRESENTATIVE_NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.STAFF_NAME" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.STATUS" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.TAX_AUTHORITY" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.TAX_CODE" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.TAX_DEPARTMENT" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.TEL_NUMBER" /></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.DATE_REGISTER" /></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.LAST_UPLOAD_DATE" /></td>
						<td>
							<a href="#"><span class="fa fa-plus-square-o"></span></a>
						</td>
					</tr>
				</table>
				<div class="mt-2 mb-2 pl-2 pr-2">
					<button class="btn btn-primary" ng-click="addMul()" ng-disabled="addMulDisabled">Thêm</button>
					<button class="btn btn-secondary" ng-click="mode='list'">Quay lại</button>
				</div>
			</div>
			
			<div class="mt-2 mb-2 pl-2 pr-2">
			<select ng-model="rows" ng-options="rows_item as rows_item for rows_item in all_rows" ng-change="reload()" class="btn btn-primary btn-sm">
			</select>
			<a class="btn btn-sm" ng-repeat="p in pages()" ng-click="changePage(p)" ng-class="{'btn-primary text-white': page==p, 'btn-secondary text-white': page!=p}"><% p %></a>
			</div>
			<div class="card-footer">Phân trang</div>
		</div>
	</div>


	<!-- Modals -->

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Nhập dữ liệu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<input id="import_file" type="file" />
				<div id="progress-wrp">
					<div class="progress-bar"></div>
					<div class="status">0%</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" ng-click="import()">Bắt đầu</button>
			</div>
		</div>
	</div>
		
	<!-- End Modals -->
</div>

<style>
#progress-wrp {
  border: 1px solid #0099CC;
  padding: 1px;
  position: relative;
  height: 30px;
  border-radius: 3px;
  margin: 10px;
  text-align: left;
  background: #fff;
  box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}

#progress-wrp .progress-bar {
  height: 100%;
  border-radius: 3px;
  background-color: #f39ac7;
  width: 0;
  box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}

#progress-wrp .status {
  top: 3px;
  left: 50%;
  position: absolute;
  display: inline-block;
  color: #000000;
}
</style>
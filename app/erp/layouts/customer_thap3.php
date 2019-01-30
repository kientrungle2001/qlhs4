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
<div class="row no-gutters mt-3 table-reduce-font" ng-app="erpApp" ng-controller="thapController">
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
						<th><span class="text-primary">Ngày nhận</span><br /><span class="text-danger">Ngày gửi YC</span><br /><span class="text-success">Ngày Hoàn thiện HS</span><br /><span class="text-info">Ngày KHTT về CT</span><br /><span class="text-warning">Ngày bàn giao HS đến phòng DVKH</span><br />Ngày TT NCC<br />Ngày TT TB cho NCC<br />Ngày hủy DV<br />Trạng thái</th>
						<th>MST<br />Tên doanh nghiệp<br />Mã đơn vị<br />KH Phát sinh <br />Note PKT<br />Note<br />Giao phát<br />Ngày vàng</th>
						<th>TG Gen<br />Số hợp đồng<br />Số hóa đơn<br />Hình thức TT<br />NV Kinh doanh</th>
						<th>Tên khách hàng<br />SĐT<br />Email<br />Địa chỉ VAT<br />Địa chỉ trả TB<br />Khu vực cài đặt</th>
						<th>Số năm<br />Gói hóa đơn<br />Nhà CC<br />Nhà CC, TB, HĐ<br />Số LĐ</th>
						<th>Mức điểm<br />Số tiền<br />Phí DV<br />Chiết khấu<br />Còn thu<br />Đã thu<br />Tỉ lệ hoa hồng<br />Doanh thu được hưởng</th>
						<th>Người trả<br />Ngày nhận trả</th>
						<th>Spam tính lương<br />Tình trạng Spam</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in items" ng-click="itemSelecteds[item.id] = !itemSelecteds[item.id]">
						<td><input type="checkbox" ng-model="itemSelecteds[item.id]" /></td>
						<td><% item.id%></td>
						<td><span class="text-primary"><% item.ngay_nhan | vndate%></span><br /><span class="text-danger"><% item.ngay_gui_yc | vndate%></span><br /><span class="text-success"><% item.ngay_hoan_thien_hs | vndate%></span><br /><span class="text-info"><% item.ngay_thanh_toan_tien_kh_ve_cty | vndate%></span><br /><span class="text-warning"><% item.ngay_ban_giao_hs_den_pdvkh | vndate%></span><br /><% item.ngay_tt_ncc | vndate%><br /><% item.ngay_tt_tb_den_ncc | vndate%><br /><% item.ngay_huy_dv | vndate%><br />
							<span class="btn btn-info btn-sm"><% item.tinh_trang%></span><br />
							<a href="javascript:void(0)" ng-click="duplicate(item)">Sao chép</a>
						</td>
						<td><% item.mst%><br /><a href="javascript:void(0)" ng-click="edit(item)"> <span class="fa fa-pencil-square-o"></span> <% item.ten_doanh_nghiep%></a><br /><% item.ma_don_vi%><br /><% item.kh_phat_sinh%><br /><% item.note_pkt%><br /><% item.note%><br /><% item.co_hoa_don | co_hd%><br /><% item.co_thiet_bi | co_tb%><br />giao phát: <% item.giao_phat%><br />Ngày vàng: <% item.ngay_vang%></td>
						<td><% item.thoi_gian_gen | vndate%><br /><% item.so_hop_dong%><br /><% item.so_hoa_don%><br /><% item.hinh_thuc_thanh_toan%><br /><% item.nhan_vien_kinh_doanh%></td>
						<td><% item.ten_khach_hang%><br /><% item.so_dien_thoai%><br /><% item.email%><br /><% item.dia_chi_vat%><br /><% item.dia_chi_tra%><br /><% item.khu_vuc_cai_dat%></td>
						<td><% item.so_nam%><br /><% item.goi_hoa_don%><br /><% item.nha_cc%><br /><% item.ncc_tb_hd%><br /><% item.so_ld%></td>
						<td><% item.muc_diem%><br /><% item.so_tien  | vnprice%><br /><% item.phi_dich_vu  | vnprice%>
							<br /><% item.chiet_khau  | vnprice%><br /><% item.con_thu  | vnprice%>
							<br /><% item.da_thu  | vnprice%><br /><% item.hoa_hong%>
							<br /><% item.doanh_thu  | vnprice%></td>
						<td><% item.nguoi_tra%><br /><% item.ngay_nhan_tra | vndate%></td>
						<td><% item.spam_tinh_luong%><br /><% item.tinh_trang_spam%></td>
					</tr>
				</tbody>
			</table>
			
			<div class="card-body" ng-show="mode=='edit' || mode=='add'">
			<h5 class="card-title">Chi tiết</h5>
			<button href="javascript:void(0)" ng-click="save()" class="btn btn-primary">Lưu</button>
				<button href="javascript:void(0)" ng-click="resetAdd()" class="btn btn-secondary" ng-show="mode=='add'">Clear</button>
				<button href="javascript:void(0)" ng-click="cancel()" class="btn btn-secondary">Quay lại</button>
				<p class="card-text">
					<div class="row">
						<div class="col-md-2">
						<label>Tình trạng:</label> 
						<select ng-model="selectedItem.tinh_trang" class="form-control form-control-sm">
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
						<div class="col-md-2">
						<label>Có hóa đơn:</label> 
						<select ng-model="selectedItem.co_hoa_don" class="form-control form-control-sm">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>	
						</div>
						<div class="col-md-2">
						<label>Có thiết bị:</label> 
						<select ng-model="selectedItem.co_thiet_bi" class="form-control form-control-sm">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>		
						</div>
						<div class="col-md-2">
						<label>Ngày vàng:</label> 
						<select ng-model="selectedItem.ngay_vang" class="form-control form-control-sm">
							<option value="0">Không có</option>
							<option value="1.5">Nhân 1.5</option>
							<option value="2">Nhân 2</option>
						</select>
						</div>
						<div class="col-md-2">
						<label>Giao phát:</label> 
						<select ng-model="selectedItem.giao_phat" class="form-control form-control-sm">
							<option value="NO">Không có</option>
							<option value="COD">Thu tiền hộ</option>
							<option value="IMS">Nhân 1.5</option>
							<option value="KTT">Kỹ thuật trả</option>
						</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Nhân viên kinh doanh:</label> 
							<select ng-model="selectedItem.id_nhan_vien_kinh_doanh" class="form-control form-control-sm"
									ng-options="sale.id as (sale.CODE + ' - ' + sale.NAME) for sale in saleStaffs track by sale.id"
									ng-change="chonNVKD()">
								<option value="">Chọn NVKD</option>
							</select>	
							<input type="text" ng-model="selectedItem.nhan_vien_kinh_doanh" readonly
									class="form-control form-control-sm" />
						</div>
						<div class="col-md-8">
							<label>Note:</label> 
							<textarea ng-model="selectedItem.note" class="form-control form-control-sm"></textarea>	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin hợp đồng</h6>
				<p class="card-text">
				<div class="row">
					<div class="col-md-2 form-group">
						<label>Ngày nhận: <% selectedItem.ngay_nhan | vndate %></label>
						<input jqdatepicker ng-model="selectedItem.ngay_nhan" datetime="yyyy-MM-dd" class="form-control form-control-sm" />
					</div>
					<div class="col-md-2">
						<label>Ngày gửi YC: <% selectedItem.ngay_gui_yc | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_gui_yc" datetime="yyyy-MM-dd" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Thời gian GEN: <% selectedItem.thoi_gian_gen | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.thoi_gian_gen" datetime="yyyy-MM-dd" class="form-control form-control-sm" />
					</div>
					<div class="col-md-2">
						<label>Số hợp đồng: </label>
						<input ng-model="selectedItem.so_hop_dong" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Số hóa đơn:</label>
						<input ng-model="selectedItem.so_hoa_don" class="form-control form-control-sm" />
					</div>
				</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin công ty</h6>
				<p class="card-text">
					
					<div class="row">
						<div class="col-md-4">
						<label>Mã số thuế:</label> 
						<input ng-model="selectedItem.mst" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-8">
						<label>Tên công ty:</label> 
						<input ng-model="selectedItem.ten_doanh_nghiep" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						<label>Chủ thể:</label> 
						<input ng-model="selectedItem.ten_khach_hang" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Số điện thoại:</label> 
						<input ng-model="selectedItem.so_dien_thoai" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Email:</label> 
						<input ng-model="selectedItem.email" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
						<label>Địa chỉ VAT:</label> 
						<textarea ng-model="selectedItem.dia_chi_vat" class="form-control form-control-sm"></textarea>	
						</div>
						<div class="col-md-6">
						<label>Địa chỉ trả TB:</label> 
						<textarea ng-model="selectedItem.dia_chi_tra" class="form-control form-control-sm"></textarea>	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nội dung dịch vụ</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-4">
						<label>Gói Hóa đơn:</label> 
						<input ng-model="selectedItem.goi_hoa_don" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Nhà cung cấp:</label> 
						<input ng-model="selectedItem.nha_cc" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Số năm:</label> 
						<input ng-model="selectedItem.so_nam" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						<label>Số tiền: <% selectedItem.so_tien | vnprice %></label> 
						<input ng-model="selectedItem.so_tien" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Phí dịch vụ: <% selectedItem.phi_dich_vu | vnprice %></label> 
						<input ng-model="selectedItem.phi_dich_vu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Chiết khấu: <% selectedItem.chiet_khau | vnprice %></label> 
						<input ng-model="selectedItem.chiet_khau" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
						<label>Đã thu: <% selectedItem.da_thu | vnprice %></label> 
						<input ng-model="selectedItem.da_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Còn thu: <% selectedItem.con_thu | vnprice %></label> 
						<input ng-model="selectedItem.con_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hoa hồng: </label> 
						<input ng-model="selectedItem.hoa_hong" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Doanh thu: <% selectedItem.doanh_thu | vnprice %></label> 
						<input ng-model="selectedItem.doanh_thu" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Ngày trả</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày trả: <% selectedItem.ngay_nhan_tra | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_nhan_tra" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Người trả:</label> 
						<input ng-model="selectedItem.nguoi_tra" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kinh doanh</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-3">
						<label>Ngày hoàn thiện hồ sơ: <% selectedItem.ngay_hoan_thien_hs | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_hoan_thien_hs" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày thanh toán tiền KH về cty: <% selectedItem.ngay_thanh_toan_tien_kh_ve_cty | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_thanh_toan_tien_kh_ve_cty" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hình thức thanh toán:</label> 
						<input ng-model="selectedItem.hinh_thuc_thanh_toan" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày bàn giao HS đến PDVKH: <% selectedItem.ngay_ban_giao_hs_den_pdvkh | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_ban_giao_hs_den_pdvkh" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nhà cung cấp</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày thanh toán cho NCC: <% selectedItem.ngay_tt_ncc | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_tt_ncc" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Ngày thanh toán TB đến NCC: <% selectedItem.ngay_tt_tb_den_ncc | vndate %></label> 
						<input jqdatepicker ng-model="selectedItem.ngay_tt_tb_den_ncc" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kỹ thuật</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Nhân viên kỹ thuật:</label> 
						<input ng-model="selectedItem.nhan_vien_ky_thuat" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Note Phòng Kỹ Thuật:</label> 
						<textarea ng-model="selectedItem.note_pkt" class="form-control form-control-sm"></textarea>	
						</div>
					</div>
				</p>
				<h6>Spam tính lương</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-3">
						<label>Spam tính lương:</label> 
						<select ng-model="selectedItem.spam_tinh_luong" class="form-control form-control-sm">
						<option value="">Spam tính lương</option>
							<option value="yes">Có</option>
							<option value="no">Không</option>
						</select>	
						</div>
						<div class="col-md-3">
						<label>Tình trạng spam:</label> 
						<input ng-model="selectedItem.tinh_trang_spam" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>NCC TB, HĐ:</label> 
						<input ng-model="selectedItem.ncc_tb_hd" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>KH phát sinh:</label> 
						<input ng-model="selectedItem.kh_phat_sinh" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<button href="javascript:void(0)" ng-click="save()" class="btn btn-primary">Lưu</button>
				<button href="javascript:void(0)" ng-click="resetAdd()" class="btn btn-secondary" ng-show="mode=='add'">Clear</button>
				<button href="javascript:void(0)" ng-click="cancel()" class="btn btn-secondary">Quay lại</button>
			</div>

			<div class="card-body" ng-show="mode=='addmul'">
				<table class="table table-sm" style="width: 6000px;">
					<tr>
						<th>&nbsp;</th>
						<th>NGÀY NHẬN</th>
						<th>NGÀY GỬI Y/C</th>
						<th>MST</th>
						<th>TÊN DOANH NGHIỆP</th>
						<th>TG GEN</th>
						<th>Mã đơn vị</th>
						<th>SỐ HỢP ĐỒNG</th>
						<th>SỐ HÓA ĐƠN</th>
						<th>Tên khách hàng</th>
						<th>SĐT</th>
						<th>EMAIL</th>
						<th>ĐỊA CHỈ VAT</th>
						<th>Đ/C TRẢ TB</th>
						<th>Khu Vực Cài đặt</th>
						<th>Tên nhân viên KD</th>
						<th>Số năm</th>
						<th>Gói hóa đơn</th>
						<th>NHÀ CC</th>
						<th>Mức điểm</th>
						<th>SỐ TIỀN</th>
						<th>Phí DV </th>
						<th>CHIẾT KHẤU</th>
						<th>CÒN THU</th>
						<th>ĐÃ THU</th>
						<th>Tỉ lệ hoa hồng</th>
						<th>Doanh thu được hường</th>
						<th>NGƯỜI TRẢ</th>
						<th>NGÀY NHẬN TRẢ</th>
						<th>NGÀY HOÀN THIỆN HS</th>
						<th>Ngày thanh toán tiền của KH về công ty</th>
						<th>TÌNH TRẠNG</th>
						<th>HÌNH THỨC TT (TM/CK/ để trống nếu chưa TT)</th>
						<th>Ngày bàn giao HS đến PDVKH</th>
						<th>NGÀY TT NCC (ngày thanh toán cước cho nhà cung cấp)</th>
						<th>Ngày Thanh toán TB cho NCC</th>
						<th>Note ( Phòng KT)</th>
						<th>Số LĐ</th>
						<th>Note (tiêu đề)</th>
						<th>SPAM TÍNH LƯƠNG</th>
						<th>TÌNH TRẠNG SPAM</th>
						<th>NCC TB, HĐ</th>
						<th>KH phát sinh</th>
						<th>&nbsp;</th>
					</tr>
					<tr ng-repeat="item in multipleItems">
						<td>
							<a href="#" ng-click="addMulItem()"><span class="fa fa-plus-square-o"></span></a>
							<a href="#" ng-click="removeMulItem($index)"><span class="fa fa-remove text-danger"></span></a>
						</td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_nhan" /></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_gui_yc" /></td>
						<td><input class="form-control form-control-sm" ng-model="item.mst"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.ten_doanh_nghiep"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.thoi_gian_gen"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.ma_don_vi"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.so_hop_dong"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.so_hoa_don"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.ten_khach_hang"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.so_dien_thoai"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.email"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.dia_chi_vat"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.dia_chi_tra"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.khu_vuc_cai_dat"/></td>
						<td>
							<select ng-model="item.id_nhan_vien_kinh_doanh" class="form-control form-control-sm"
									ng-options="sale.id as (sale.CODE + ' - ' + sale.NAME) for sale in saleStaffs track by sale.id"
									ng-change="chonNVKDMul(item)">
								<option value="">Chọn NVKD</option>
							</select>
						</td>
						<td><input class="form-control form-control-sm" ng-model="item.so_nam"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.goi_hoa_don"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.nha_cc"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.muc_diem"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.so_tien"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.phi_dich_vu"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.chiet_khau"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.con_thu"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.da_thu"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.hoa_hong"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.doanh_thu"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.nguoi_tra"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_nhan_tra"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_hoan_thien_hs"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_thanh_toan_tien_kh_ve_cty"/></td>
						<td><select ng-model="item.tinh_trang" class="form-control form-control-sm">
							<option value="new">Mới</option>
							<option value="processing">Điều phối viên đang xử lý</option>
							<option value="provider">Đang chuyển sang nhà cung cấp</option>
							<option value="provider-processed">Nhà cung cấp đã xử lý</option>
							<option value="technical">Đang chuyển cho phòng kỹ thuật</option>
							<option value="technical-processed">Phòng kỹ thuật</option>
							<option value="shipping">Đang chuyển cho bộ phận giao vận</option>
							<option value="shipped">Đã giao</option>
							<option value="completed">Đã xong</option>
						</select></td>
						<td><input class="form-control form-control-sm" ng-model="item.hinh_thuc_thanh_toan"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_ban_giao_hs_den_pdvkh"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_tt_ncc"/></td>
						<td><input jqdatepicker class="form-control form-control-sm" ng-model="item.ngay_tt_tb_den_ncc"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.note_pkt"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.so_ld"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.note"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.spam_tinh_luong"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.tinh_trang_spam"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.ncc_tb_hd"/></td>
						<td><input class="form-control form-control-sm" ng-model="item.kh_phat_sinh"/></td>
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
<script>
	loginId = <?php echo pzk_session('loginId');?>;
	usertype = <?php echo pzk_session('usertype');?>;
</script>
<div class="row" ng-app="erpApp" ng-controller="thapController">
	<div class="col-md-6">
		<div class="mb-2 mt-2">
			Tìm kiếm <input ng-model="keyword" ng-change="search()" class="form-control form-control-sm" style="width: 150px; display: inline-block;" />
			<select ng-model="selectedSale" ng-change="selectSaleStaff()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;"
					ng-options="sale as (sale.CODE + ' - ' + sale.NAME) for sale in saleStaffs track by sale.id">
				<option value="">Chọn NVKD</option>
			</select>

			<select ng-model="selectedProvider" ng-change="selectProvider()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;">
				<option value="">Nhà cung cấp</option>
				<option value="VINA">VINA</option>
				<option value="VIETEL">VIETEL</option>
				<option value="VNPT">VNPT</option>
			</select>

			<select ng-model="tinh_trang" ng-change="chonTinhTrang()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;">
				<option value="">Trạng thái</option>
				<option value="new">Mới</option>
				<option value="provider">Đang chuyển cho nhà cung cấp</option>
			</select>

			<select ng-model="spam_tinh_luong" ng-change="chonSpamTinhLuong()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;">
				<option value="">Spam tính lương</option>
				<option value="yes">Có</option>
				<option value="no">Không</option>
			</select>

			<select ng-model="co_hoa_don" ng-change="chonCoHoaDon()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;">
				<option value="">Có hóa đơn</option>
				<option value="1">Có</option>
				<option value="0">Không</option>
			</select>

			<select ng-model="co_thiet_bi" ng-change="chonCoThietBi()" 
					class="form-control form-control-sm" style="width: 150px; display: inline-block;">
				<option value="">Có thiết bị</option>
				<option value="1">Có</option>
				<option value="0">Không</option>
			</select>

		</div>
		<div class="mb-2 mt-2">
			
			<button for="checkAllItems" class="btn btn-primary btn-sm" ng-click="checkAllItems=!checkAllItems; toggleSelectedItems()"><input type="checkbox" id="checkAllItems" ng-model="checkAllItems" ng-change="toggleSelectedItems()" /> Chọn tất</button>
			<button class="btn btn-primary btn-sm" ng-click="mode='add'">Thêm mới</button>
			<button class="btn btn-primary btn-sm" ng-click="export()">Xuất dữ liệu</button>
			<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal">Nhập dữ liệu </button>
			<select ng-model="mode" ng-init="mode = ''" class="btn btn-primary btn-sm">
				<option value="">Chọn chế độ</option>
				<option value="view">Chế độ xem</option>
				<option value="edit">Chế độ sửa</option>
				<option value="add">Chế độ thêm</option>
			</select>
		</div>
		<div class="list-group">
			<div class="list-group-item" ng-repeat="item in items" ng-class="{'active': selectedItem && (selectedItem.id === item.id)}" ng-click="detail(item)">
				<div class="row">
					<div class="col-md-3" title="MST">
						<input type="checkbox" ng-model="itemSelecteds[item.id]"/>
						<% item.mst %><br/><span class="fa fa-map-marker"></span> <% item.khu_vuc_cai_dat %><br />
						<% item.tinh_trang%>
						</div>
					<div class="col-md-5" title="Tên công ty"><span class="fa fa-building-o"></span> <% item.ten_doanh_nghiep %><br />
					<span class="fa fa-address-book-o"></span> <% item.ten_khach_hang%>  <span class="fa fa-phone"></span> <% item.so_dien_thoai%><br /><span class="fa fa-envelope-o"></span> <% item.email%>
					</div>
					<div class="col-md-3">
						<span class="fa fa-calendar-o"> <% item.ngay_gui_yc | vndate %></span><br />
						<span class="fa fa-calendar"> <% item.ngay_nhan | vndate %> </span><br />
						<span class="fa fa-money btn btn-danger btm-sm"> <% item.so_tien | vnprice %></span> <br />
						<span class="fa fa-money btn btn-warning btm-sm"> <% item.con_thu | vnprice %> </span><br />
						<span class="fa fa-money btn btn-success btm-sm"> <% item.da_thu | vnprice %> </span><br />
						<span class="fa fa-money btn btn-info btm-sm"> <% item.doanh_thu | vnprice %> </span><br />
					</div>
					<div class="col-md-1"><a href="#" ng-click="detail(item)"> <span class="fa fa-play"></span> </a></div>
				</div>
				<div class="row">
					<div class="col-md-3" title="Gói dịch vụ">&nbsp;<% item.goi_hoa_don%></div>
					<div class="col-md-5" title="Khách hàng"><% item.nha_cc%>(<% item.so_nam%>)</div>
					<div class="col-md-3">NVKD: <% item.nhan_vien_kinh_doanh%><br />
					NVKT: <% item.nhan_vien_ky_thuat%>
					</div>
				</div>
			</div>
		</div>
		<div class="thap-pagination">
			<select ng-model="rows" ng-options="rows_item as rows_item for rows_item in all_rows" ng-change="reload()">
			</select>
			
			<a class="page" ng-repeat="p in pages()" ng-click="changePage(p)" ng-class="{'active': page==p}"><% p %></a>
		</div>
		<div class="thap-actions">
			Xuất dữ liệu | Nhập dữ liệu | Phân công | Phân loại
		</div>
	</div>
	<div class="col-md-6">

		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Nghiệp vụ</h5>
				<p class="card-text">
				Nghiệp vụ
				</p>
			</div>
		</div>

		<!-- view mode -->
		<div class="card" ng-show="mode=='' || mode=='view'">
			
			<div class="card-body">
				<button class="btn btn-danger" ng-click="mode='edit'">Chế độ sửa</button>
				<button class="btn btn-primary" ng-click="mode='add'">Thêm mới</button>
				<h5 class="card-title">Chi tiết</h5>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin hợp đồng</h6>
				<p class="card-text">
				Ngày nhận: <% selectedItem.ngay_nhan%> - Ngày gửi YC: <% selectedItem.ngay_gui_yc%> - Số hợp đồng: <% selectedItem.so_hop_dong%> - Số hóa đơn: <% selectedItem.so_hoa_don%><br />
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin công ty</h6>
				<p class="card-text">
				Mã số thuế: <% selectedItem.mst%> - Tên công ty: <% selectedItem.ten_doanh_nghiep%><br />
				Chủ thể: <% selectedItem.ten_khach_hang%> - <% selectedItem.email%> - <% selectedItem.so_dien_thoai%><br />
				Địa chỉ VAT: <% selectedItem.dia_chi_vat%><br />
				Địa chỉ trả TB: <% selectedItem.dia_chi_tra%>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nội dung dịch vụ</h6>
				<p class="card-text">
				Gói Hóa đơn: <% selectedItem.goi_hoa_don%> - Nhà cung cấp: <% selectedItem.nha_cc%> - Số năm: <% selectedItem.so_nam%><br />
				Số tiền: <% selectedItem.so_tien%> - Phí dịch vụ: <% selectedItem.phi_dich_vu%> - Chiết khấu: <% selectedItem.chiet_khau%> - Đã thu: <% selectedItem.da_thu%> - Còn thu: <% selectedItem.con_thu%><br />
				Hoa hồng: <% selectedItem.hoa_hong%> - Doanh thu: <% selectedItem.doanh_thu%>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Ngày trả</h6>
				<p class="card-text">
				Ngày trả: <% selectedItem.ngay_nhan_tra%> - Người trả: <% selectedItem.nguoi_tra%>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kinh doanh</h6>
				<p class="card-text">
				Ngày hoàn thiện hồ sơ: <% selectedItem.ngay_hoan_thien_hs%> - Ngày thanh toán tiền KH về cty: <% selectedItem.ngay_thanh_toan_tien_kh_ve_cty%><br />
				Hình thức thanh toán: <% selectedItem.hinh_thuc_thanh_toan%><br />
				Ngày bàn giao HS đến PDVKH: <% selectedItem.ngay_ban_giao_hs_den_pdvkh %>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nhà cung cấp</h6>
				<p class="card-text">
				Ngày thanh toán cho NCC: <% selectedItem.ngay_tt_ncc %>
				Ngày thanh toán TB đến NCC: <% selectedItem.ngay_tt_tb_den_ncc %>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kỹ thuật</h6>
				<p class="card-text">
				Nhân viên kỹ thuật: <% selectedItem.nhan_vien_ky_thuat%><br />
				Note Phòng Kỹ Thuật: <% selectedItem.note_pkt%><br />
				</p>
				<h6>Spam tính lương</h6>
				<p class="card-text">
				Spam tính lương: <% selectedItem.spam_tinh_luong%><br />
				Tình trạng spam: <% selectedItem.tinh_trang_spam%><br />
				NCC TB, HĐ: <% selectedItem.ncc_tb_hd%><br />
				Khách hàng phát sinh: <% selectedItem.kh_phat_sinh%>
				</p>
			</div>
		</div>
		<!-- end view mode -->

		<!-- edit mode -->
		<div class="card" ng-show="mode=='edit'">
			<div class="card-body">
				<button class="btn btn-danger" ng-click="mode='view'">Chế độ xem</button>
				<button class="btn btn-primary" ng-click="mode='add'">Thêm mới</button>
				<h5 class="card-title">Chi tiết</h5>
				<p class="card-text">
					<div class="row">
						<div class="col-md-4">
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
						<div class="col-md-4">
						<label>Có hóa đơn:</label> 
						<select ng-model="selectedItem.co_hoa_don" class="form-control form-control-sm">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>	
						</div>
						<div class="col-md-4">
						<label>Có thiết bị:</label> 
						<select ng-model="selectedItem.co_thiet_bi" class="form-control form-control-sm">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>		
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin hợp đồng</h6>
				<p class="card-text">
				<div class="row">
					<div class="col-md-3 form-group">
						<label>Ngày nhận: </label>
						<input ng-model="selectedItem.ngay_nhan" datetime="yyyy-MM-dd" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Ngày gửi YC:</label> 
						<input ng-model="selectedItem.ngay_gui_yc" datetime="yyyy-MM-dd" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
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
						<label>Số tiền:</label> 
						<input ng-model="selectedItem.so_tien" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Phí dịch vụ:</label> 
						<input ng-model="selectedItem.phi_dich_vu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Chiết khấu:</label> 
						<input ng-model="selectedItem.chiet_khau" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
						<label>Đã thu:</label> 
						<input ng-model="selectedItem.da_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Còn thu:</label> 
						<input ng-model="selectedItem.con_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hoa hồng:</label> 
						<input ng-model="selectedItem.hoa_hong" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Doanh thu:</label> 
						<input ng-model="selectedItem.doanh_thu" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Ngày trả</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày trả:</label> 
						<input ng-model="selectedItem.ngay_nhan_tra" class="form-control form-control-sm" />	
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
						<label>Ngày hoàn thiện hồ sơ:</label> 
						<input ng-model="selectedItem.ngay_hoan_thien_hs" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày thanh toán tiền KH về cty:</label> 
						<input ng-model="selectedItem.ngay_thanh_toan_tien_kh_ve_cty" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hình thức thanh toán:</label> 
						<input ng-model="selectedItem.hinh_thuc_thanh_toan" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày bàn giao HS đến PDVKH:</label> 
						<input ng-model="selectedItem.ngay_ban_giao_hs_den_pdvkh" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nhà cung cấp</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày thanh toán cho NCC:</label> 
						<input ng-model="selectedItem.ngay_tt_ncc" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Ngày thanh toán TB đến NCC:</label> 
						<input ng-model="selectedItem.ngay_tt_tb_den_ncc" class="form-control form-control-sm" />	
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
				<button href="#" ng-click="save()" class="btn btn-primary">Lưu</button>
			</div>
		</div>
		<!-- end edit mode -->

		<!-- add mode -->
		<div class="card" ng-show="mode=='add'">
			<div class="card-body">

				<h5 class="card-title">Chi tiết</h5>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin hợp đồng</h6>
				<p class="card-text">
				<div class="row">
					<div class="col-md-3 form-group">
						<label>Ngày nhận: </label>
						<input ng-model="addItem.ngay_nhan" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Ngày gửi YC:</label> 
						<input ng-model="addItem.ngay_gui_yc" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Số hợp đồng: </label>
						<input ng-model="addItem.so_hop_dong" class="form-control form-control-sm" />
					</div>
					<div class="col-md-3">
						<label>Số hóa đơn:</label>
						<input ng-model="addItem.so_hoa_don" class="form-control form-control-sm" />
					</div>
				</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Thông tin công ty</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-4">
						<label>Mã số thuế:</label> 
						<input ng-model="addItem.mst" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-8">
						<label>Tên công ty:</label> 
						<input ng-model="addItem.ten_doanh_nghiep" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						<label>Chủ thể:</label> 
						<input ng-model="addItem.ten_khach_hang" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Số điện thoại:</label> 
						<input ng-model="addItem.so_dien_thoai" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Email:</label> 
						<input ng-model="addItem.email" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
						<label>Địa chỉ VAT:</label> 
						<textarea ng-model="addItem.dia_chi_vat" class="form-control form-control-sm"></textarea>	
						</div>
						<div class="col-md-6">
						<label>Địa chỉ trả TB:</label> 
						<textarea ng-model="addItem.dia_chi_tra" class="form-control form-control-sm"></textarea>	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nội dung dịch vụ</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-4">
						<label>Gói Hóa đơn:</label> 
						<input ng-model="addItem.goi_hoa_don" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Nhà cung cấp:</label> 
						<input ng-model="addItem.nha_cc" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Số năm:</label> 
						<input ng-model="addItem.so_nam" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						<label>Số tiền:</label> 
						<input ng-model="addItem.so_tien" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Phí dịch vụ:</label> 
						<input ng-model="addItem.phi_dich_vu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-4">
						<label>Chiết khấu:</label> 
						<input ng-model="addItem.chiet_khau" class="form-control form-control-sm" />	
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
						<label>Đã thu:</label> 
						<input ng-model="addItem.da_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Còn thu:</label> 
						<input ng-model="addItem.con_thu" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hoa hồng:</label> 
						<input ng-model="addItem.hoa_hong" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Doanh thu:</label> 
						<input ng-model="addItem.doanh_thu" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Ngày trả</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày trả:</label> 
						<input ng-model="addItem.ngay_nhan_tra" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Người trả:</label> 
						<input ng-model="addItem.nguoi_tra" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kinh doanh</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-3">
						<label>Ngày hoàn thiện hồ sơ:</label> 
						<input ng-model="addItem.ngay_hoan_thien_hs" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày thanh toán tiền KH về cty:</label> 
						<input ng-model="addItem.ngay_thanh_toan_tien_kh_ve_cty" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Hình thức thanh toán:</label> 
						<input ng-model="addItem.hinh_thuc_thanh_toan" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Ngày bàn giao HS đến PDVKH:</label> 
						<input ng-model="addItem.ngay_ban_giao_hs_den_pdvkh" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Nhà cung cấp</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Ngày thanh toán cho NCC:</label> 
						<input ng-model="addItem.ngay_tt_ncc" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Ngày thanh toán TB đến NCC:</label> 
						<input ng-model="addItem.ngay_tt_tb_den_ncc" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<h6 class="card-subtitle mb-2 text-muted">Dành cho kỹ thuật</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-6">
						<label>Nhân viên kỹ thuật:</label> 
						<input ng-model="addItem.nhan_vien_ky_thuat" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-6">
						<label>Note Phòng Kỹ Thuật:</label> 
						<textarea ng-model="addItem.note_pkt" class="form-control form-control-sm"></textarea>	
						</div>
					</div>
				</p>
				<h6>Spam tính lương</h6>
				<p class="card-text">
					<div class="row">
						<div class="col-md-3">
						<label>Spam tính lương:</label> 
						<input ng-model="addItem.spam_tinh_luong" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>Tình trạng spam:</label> 
						<input ng-model="addItem.tinh_trang_spam" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>NCC TB, HĐ:</label> 
						<input ng-model="addItem.ncc_tb_hd" class="form-control form-control-sm" />	
						</div>
						<div class="col-md-3">
						<label>KH phát sinh:</label> 
						<input ng-model="addItem.kh_phat_sinh" class="form-control form-control-sm" />	
						</div>
					</div>
				</p>
				<button href="#" ng-click="add()" class="btn btn-primary">Thêm mới</button>
				<button href="#" ng-click="resetAdd()" class="btn btn-default">Clear</button>
				<button href="#" ng-click="mode='view'" class="btn btn-secondary">Chuyển chế độ xem</button>
				<button href="#" ng-click="mode='edit'" class="btn btn-secondary">Chuyển chế độ sửa</button>
			</div>
		</div>
		<!-- end add mode -->
	</div>
	<div class="modals">
		<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Xuất dữ liệu</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							<h6>Chọn định dạng: <select ng-model="exportConfig.type" ng-init="exportConfig.type='xlsx'">
								<option value="json">JSON</option>
								<option value="xlsx">XLSX</option>
								<option value="csv">CSV</option>
								<option value="html">HTML</option>
							</select>
							</h6>
							<h6>Chọn trường</h6>
							<div class="row">
								<div class="col-md-6" ng-repeat="field in fields">
									<div class="row">
										<div class="col-md-6">
											<input id="export-field-<% field%>" type="checkbox" ng-init="exportConfig.fields[field].checked = true" ng-model="exportConfig.fields[field].checked" />
											<label for="export-field-<% field%>"><% field%></label>

										</div>
										<div class="col-md-6">
										<input class="form-control" ng-init="exportConfig.fields[field].title = field" ng-model="exportConfig.fields[field].title" />
										</div>
									</div>
									</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
						<button type="button" class="btn btn-primary" ng-click="export()">Bắt đầu</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

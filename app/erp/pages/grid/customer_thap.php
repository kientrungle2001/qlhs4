<div>
<dg.dataGrid id="dg" title="THAP" 
		table="customer_thap2" width="2900px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="ngay_nhan" width="120">Ngày nhận</dg.dataGridItem>
	<dg.dataGridItem field="mst" width="120">Mã số thuế</dg.dataGridItem>
	<dg.dataGridItem field="ten_doanh_nghiep" width="120">Tên doanh nghiệp</dg.dataGridItem>
	<dg.dataGridItem field="nguoi_nhan_ttkh" width="120">Người nhận TTKH</dg.dataGridItem>
	<dg.dataGridItem field="goi_cuoc" width="120">Gói cước</dg.dataGridItem>
	<dg.dataGridItem field="nha_cc" width="120">Nhà cung cấp</dg.dataGridItem>
	<dg.dataGridItem field="so_tien" width="120">Số tiền</dg.dataGridItem>
	<dg.dataGridItem field="phi_dich_vu" width="120">Phí dịch vụ</dg.dataGridItem>
	<dg.dataGridItem field="chiet_khau" width="120">Chiết khấu</dg.dataGridItem>
	<dg.dataGridItem field="con_thu" width="120">Còn thu</dg.dataGridItem>
	<dg.dataGridItem field="da_thu" width="120">Đã thu</dg.dataGridItem>
	<dg.dataGridItem field="hoa_hong" width="120">Hoa hồng</dg.dataGridItem>
	<dg.dataGridItem field="phan_tram_ap" width="120">% AP</dg.dataGridItem>
	<dg.dataGridItem field="doanh_thu" width="120">Doanh thu</dg.dataGridItem>
	<dg.dataGridItem field="nguoi_tra" width="80">Người trả</dg.dataGridItem>
	<dg.dataGridItem field="ngay_nhan_tra" width="80">Ngày nhận trả</dg.dataGridItem>
	<dg.dataGridItem field="ngay_hoan_thien_hs" width="80">Ngày hoàn thiện hồ sơ</dg.dataGridItem>
	<dg.dataGridItem field="tinh_trang" width="80">Tình trạng</dg.dataGridItem>
	<dg.dataGridItem field="hinh_thuc_thanh_toan" width="80">Hình thức thanh toán</dg.dataGridItem>
	<dg.dataGridItem field="ngay_ban_giao_hs_den_pdvkh" width="80">Ngày bàn giao hồ sơ đến PDVKH</dg.dataGridItem>
	<dg.dataGridItem field="ngay_tt_ncc" width="80">Ngày Thanh toán NCC</dg.dataGridItem>
	<dg.dataGridItem field="ngay_tt_tb_den_ncc" width="80">Ngày TT TB đến NCC</dg.dataGridItem>
	<dg.dataGridItem field="note_pkt" width="80">Ghi chú PKT</dg.dataGridItem>
	<dg.dataGridItem field="ngay_huy_dv" width="80">Ngày hủy DV</dg.dataGridItem>
	<dg.dataGridItem field="note" width="80">Ghi chú</dg.dataGridItem>
	<dg.dataGridItem field="spam_tinh_luong" width="80">Spam tính lương</dg.dataGridItem>
	<dg.dataGridItem field="tinh_trang_spam" width="80">Tình trạng spam</dg.dataGridItem>
	<dg.dataGridItem field="ncc_tb_hd" width="80">NCC TB HĐ</dg.dataGridItem>
	<dg.dataGridItem field="kh_phat_sinh" width="80">KH Phát sinh</dg.dataGridItem>
	
	
	
	<layout.toolbar id="dg_toolbar">
		<layout.toolbarItem action="$dg.add()" icon="add" />
		<layout.toolbarItem action="$dg.edit()" icon="edit" />
		<layout.toolbarItem action="$dg.del()" icon="remove" />
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="1200px" height="auto" title="THAP">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="date" name="ngay_nhan" required="true" validatebox="true" label="Ngày nhận" />
			<frm.formItem name="mst" required="true" validatebox="true" label="Mã số thuế" />
			<frm.formItem name="ten_doanh_nghiep" required="true" validatebox="true" label="Tên doanh nghiệp" />
			<frm.formItem name="nguoi_nhan_ttkh" required="true" validatebox="true" label="Người nhận TTKH" />
			<frm.formItem name="goi_cuoc" required="true" validatebox="true" label="Gói cước" />
			<frm.formItem name="nha_cc" required="true" validatebox="true" label="Nhà cung cấp" />
			<frm.formItem name="so_tien" required="true" validatebox="true" label="Số tiền" />
			<frm.formItem name="phi_dich_vu" required="true" validatebox="true" label="Phí dịch vụ" />
			<frm.formItem name="chiet_khau" required="true" validatebox="true" label="Chiết khấu" />
			<frm.formItem name="con_thu" required="true" validatebox="true" label="Còn thu" />
			<frm.formItem name="da_thu" required="true" validatebox="true" label="Đã thu" />
			<frm.formItem name="hoa_hong" required="true" validatebox="true" label="Hoa hồng" />
			<frm.formItem name="phan_tram_ap" required="true" validatebox="true" label="% AP" />
			<frm.formItem name="doanh_thu" required="true" validatebox="true" label="Doanh thu" />
			<frm.formItem name="nguoi_tra" required="true" validatebox="true" label="Người trả" />
			<frm.formItem type="date" name="ngay_nhan_tra" required="true" validatebox="true" label="Ngày nhận trả" />
			<frm.formItem type="date" name="ngay_hoan_thien_hs" required="true" validatebox="true" label="Ngày hoàn thiện HS" />
			<frm.formItem name="tinh_trang" required="true" validatebox="true" label="Tình trạng" />
			<frm.formItem name="hinh_thuc_thanh_toan" required="true" validatebox="true" label="Hình thức thanh toán" />
			<frm.formItem type="date" name="ngay_ban_giao_hs_den_pdvkh" required="true" validatebox="true" label="Ngày bàn giao hồ sơ đến PDVKH" />
			<frm.formItem type="date" name="ngay_tt_ncc" required="true" validatebox="true" label="Ngày TT NCC" />
			<frm.formItem type="date" name="ngay_tt_tb_den_ncc" required="true" validatebox="true" label="Ngày TT TB đến NCC" />
			<frm.formItem name="note_pkt" required="true" validatebox="true" label="Ghi chú PKT" />
			<frm.formItem type="date" name="ngay_huy_dv" required="true" validatebox="true" label="Ngày hủy DV" />
			<frm.formItem name="note" required="true" validatebox="true" label="Ghi chú" />
			<frm.formItem name="spam_tinh_luong" required="true" validatebox="true" label="Spam tính lương" />
			<frm.formItem name="tinh_trang_spam" required="true" validatebox="true" label="Tình trạng Spam"
				type="user-defined">
					<select name="tinh_trang_spam">
						<option value="">Tình trạng spam</option>
						<option value="1">Có spam</option>
						<option value="0">Không spam</option>
					</select>
			</frm.formItem>
			<frm.formItem name="ncc_tb_hd" required="true" validatebox="true" label="NCC TB HĐ" />
			<frm.formItem name="kh_phat_sinh" required="false" validatebox="false" label="KH Phát sinh" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
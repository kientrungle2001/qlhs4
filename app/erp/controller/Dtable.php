<?php
require_once 'core/controller/Table.php';
class PzkDtableController extends PzkTableController {
	public $inserts = array(
		'customer_thap2' => array(
			'ngay_nhan',
			'ngay_gui_yc',
			'id_doanh_nghiep',
			'mst',
			'ten_doanh_nghiep',
			'thoi_gian_gen',
			'ma_don_vi',
			'so_hop_dong',
			'so_hoa_don',
			'id_khach_hang',
			'ten_khach_hang',
			'so_dien_thoai',
			'email',
			'dia_chi_vat',
			'dia_chi_tra',
			'khu_vuc_cai_dat',
			'id_nhan_vien_kinh_doanh',
			'nhan_vien_kinh_doanh',
			'id_goi_dich_vu',
			'so_nam',
			'id_dich_vu',
			'goi_hoa_don',
			'id_nha_cc',
			'nha_cc',
			'muc_diem',
			'so_tien',
			'phi_dich_vu',
			'chiet_khau',
			'con_thu',
			'da_thu',
			'hoa_hong',
			'phan_tram_ap',
			'doanh_thu',
			'nguoi_tra',
			'ngay_nhan_tra',
			'ngay_hoan_thien_hs',
			'ngay_thanh_toan_tien_kh_ve_cty',
			'tinh_trang',
			'co_hoa_don',
			'co_thiet_bi',
			'hinh_thuc_thanh_toan',
			'ngay_ban_giao_hs_den_pdvkh',
			'ngay_tt_ncc',
			'ngay_tt_tb_den_ncc',
			'id_nhan_vien_ky_thuat',
			'nhan_vien_ky_thuat',
			'note_pkt',
			'so_ld',
			'ngay_huy_dv',
			'note',
			'spam_tinh_luong',
			'tinh_trang_spam',
			'ncc_tb_hd',
			'kh_phat_sinh',
			'ngay_vang',
			'giao_phat',
			'da_doc'
		)
	);

	public $pkeys = array(
		'staff' => 'id'
	);

	public $filters = array(
		'customer_thap2' => array(
			'none' => 0
		),
		'customer_thap2_filter' => array(
			'where' => array(
				'keyword' => array(
					'sql',
					"(mst like '%?%' or ten_doanh_nghiep like '%?%')"
				),
				'id_nhan_vien_kinh_doanh' => array('equal', 'id_nhan_vien_kinh_doanh', '?'),
				'spam_tinh_luong' => array('equal', 'spam_tinh_luong', '?'),
				'tinh_trang' => array('equal', 'tinh_trang', '?'),
				'da_doc' => array('equal', 'da_doc', '?'),
				'co_hoa_don' => array('equal', 'co_hoa_don', '?'),
				'co_thiet_bi' => array('equal', 'co_thiet_bi', '?'),
				'ngay_vang' => array('equal', 'ngay_vang', '?'),
				'giao_phat' => array('equal', 'giao_phat', '?'),
				'ngayBatDau' => array('gte', 'ngay_gui_yc', '?'),
				'ngayKetThuc' => array('lte', 'ngay_gui_yc', '?'),
				'nha_cc' => array('like', 'nha_cc', '?-%'),
			)
		),
		'app_params' => array(
			'none' => 0
		),
		'app_params_filter' => array(
			'where' => array(
				'keyword' => array(
					'sql',
					"(PAR_NAME like '%?%' or PAR_TYPE like '%?%')"
				),
				'STATUS' => array('equal', 'STATUS', '?'),
				'PAR_TYPE' => array('equal', 'PAR_TYPE', '?'),
			)
		),
		'customer' => array(
			'none' => 0
		),
	);

	public $export_sets = array(
		'customer_thap2' => array(
			'default' => array(
				'fields' => array(
					array(
						'index' => 'ngay_nhan',
						'title' => 'Ngày nhận',
						'type' => 'date',
						'width'	=> 15,
						//'dateType' => 'formula'
					),
					array(
						'index' => 'ngay_gui_yc',
						'title' => 'Ngày gửi yêu cầu',
						'type' => 'date',
						'width'	=> 15,
						//'dateType' => 'date',
						//'format' => 'd/m/Y'
					),
					array(
						'index' => 'mst',
						'title' => 'Mã số thuế',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'ten_doanh_nghiep',
						'title' => 'Tên doanh nghiệp',
						'type' => 'string',
						'width'	=> 45
					),
					array(
						'index' => 'thoi_gian_gen',
						'title' => 'Thời gian gen',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'ma_don_vi',
						'title' => 'Mã đơn vị',
						'type' => 'string',
						'width'	=> 15

					),
					array(
						'index' => 'so_hop_dong',
						'title' => 'Số hợp đồng',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'so_hoa_don',
						'title' => 'Số hóa đơn',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'ten_khach_hang',
						'title' => 'Tên khách hàng',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'so_dien_thoai',
						'title' => 'Số điện thoại',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'email',
						'title' => 'Email',
						'type' => 'string',
						'width'	=> 25
					),
					array(
						'index' => 'dia_chi_vat',
						'title' => 'Địa chỉ VAT',
						'type' => 'string',
						'width'	=> 55
					),
					array(
						'index' => 'dia_chi_tra',
						'title' => 'Địa chỉ trả TB',
						'type' => 'string',
						'width'	=> 55
					),
					array(
						'index' => 'khu_vuc_cai_dat',
						'title' => 'Khu vực cài đặt',
						'type' => 'string',
						'width'	=> 15
					),
					
					array(
						'index' => 'nhan_vien_kinh_doanh',
						'title' => 'Tên nhân viên kinh doanh',
						'type' => 'string',
						'width'	=> 25
					),
					array(
						'index' => 'so_nam',
						'title' => 'Số năm',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'goi_hoa_don',
						'title' => 'Gói hóa đơn',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'nha_cc',
						'title' => 'Nhà cung cấp',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'muc_diem',
						'title' => 'Mức điểm',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'so_tien',
						'title' => 'Số tiền',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'phi_dich_vu',
						'title' => 'Phí dịch vụ',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'chiet_khau',
						'title' => 'Chiết khấu',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'con_thu',
						'title' => 'Còn thu',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'da_thu',
						'title' => 'Đã thu',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'hoa_hong',
						'title' => 'Tỉ lệ hoa hồng',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'doanh_thu',
						'title' => 'Doanh thu được hưởng',
						'type' => 'money',
						'width'	=> 15
					),
					array(
						'index' => 'nguoi_tra',
						'title' => 'Người trả',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_nhan_tra',
						'title' => 'Ngày nhận trả',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_hoan_thien_hs',
						'title' => 'Ngày hoàn thiện HS',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_thanh_toan_tien_kh_ve_cty',
						'title' => 'Ngày thanh toán tiền của KH về công ty',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'tinh_trang',
						'title' => 'Tình trạng',
						'type' => 'map',
						'map'	=> array(
							'completed' => 'Đã xong'
						),
						'width'	=> 15
					),
					array(
						'index' => 'hinh_thuc_thanh_toan',
						'title' => 'Hình thức thanh toán',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_ban_giao_hs_den_pdvkh',
						'title' => 'Ngày bàn giao HS đến PDVKH',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_tt_ncc',
						'title' => 'NGÀY TT NCC (ngày thanh toán cước cho nhà cung cấp)',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_tt_tb_den_ncc',
						'title' => 'Ngày Thanh toán TB cho NCC',
						'type' => 'date',
						'width'	=> 15
					),
					array(
						'index' => 'note_pkt',
						'title' => 'Note ( Phòng KT)',
						'type' => 'string',
						'width'	=> 45
					),
					array(
						'index' => 'so_ld',
						'title' => 'Số lao động',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'note',
						'title' => 'Note',
						'type' => 'string',
						'width'	=> 45
					),
					array(
						'index' => 'spam_tinh_luong',
						'title' => 'SPAM TÍNH LƯƠNG',
						'type' => 'map',
						'map'	=> array(
							'yes'	=>	'SPAM',
							'no'	=>	'',
							''	=>	''
						),
						'width'	=> 15
					),
					array(
						'index' => 'tinh_trang_spam',
						'title' => 'Tình trạng spam',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'ngay_vang',
						'title' => 'Ngày vàng',
						'type' => 'map',
						'map'	=> array(
							'0'	=>	'0',
							'1.5'	=>	'1.5',
							'2'	=>	'2'
						),
						'width'	=> 15
					),
					array(
						'index' => 'giao_phat',
						'title' => 'Giao phát',
						'type' => 'map',
						'map'	=> array(
							'NO'	=>	'NO',
							'COD'	=>	'COD',
							'KTT'	=>	'KTT',
							'IMS'	=>	'IMS',
							''	=>	''
						),
						'width'	=> 15
					),
					array(
						'index' => 'ncc_tb_hd',
						'title' => 'NCC TB, HĐ',
						'type' => 'string',
						'width'	=> 15
					),
					array(
						'index' => 'kh_phat_sinh',
						'title' => 'KH phát sinh',
						'type' => 'string',
						'width'	=> 15
					),
				)
			)
		)
	);
}
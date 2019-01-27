<?php
require_once 'core/controller/Table.php';
class PzkDtableController extends PzkTableController {
	public $inserts = array(
		'customer_thap2' => array(
			'ngay_nhan',
			'ngay_gui_yc',
			'mst',
			'ten_doanh_nghiep',
			'nguoi_nhan_ttkh',
			'goi_cuoc',
			'nha_cc',
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
			'tinh_trang',
			'hinh_thuc_thanh_toan',
			'ngay_ban_giao_hs_den_pdvkh',
			'ngay_tt_ncc',
			'ngay_tt_tb_den_ncc',
			'note_pkt',
			'ngay_huy_dv',
			'note',
			'spam_tinh_luong',
			'tinh_trang_spam',
			'ncc_tb_hd',
			'kh_phat_sinh',
			'co_hoa_don',
			'co_thiet_bi'
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
				'co_hoa_don' => array('equal', 'co_hoa_don', '?'),
				'co_thiet_bi' => array('equal', 'co_thiet_bi', '?'),
			)
		)
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
				)
			)
		)
	);
}
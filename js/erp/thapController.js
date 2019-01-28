
erpApp.controller('thapController', ['$scope', function($scope) {
	$scope.keyword = "";
	$scope.all_rows = [10, 20, 50, 100, 200];

	// tìm kiếm
	$scope.search = function() {
		$scope.reload();
	};
	$scope.rows = 50;
	$scope.page = 1;
	$scope.total = 0;
	$scope.truong_sap_xep = 'id';
	$scope.thu_tu_sap_xep = 'desc';
	// Hiển thị danh sách các hợp đồng
	$scope.reload = function() {
		var postData = {
			rows: $scope.rows,
			page: $scope.page,
			sort: $scope.truong_sap_xep || 'id',
			order: $scope.thu_tu_sap_xep || 'desc',
			filters: {
				keyword: $scope.keyword
			}
		};
		if($scope.keyword && jQuery.trim($scope.keyword) !== '') {
			postData.filters.keyword = jQuery.trim($scope.keyword);
		}
		if($scope.selectedSale) {
			postData.filters.id_nhan_vien_kinh_doanh = $scope.selectedSale.id;
		}
		if($scope.selectedProvider) {
			postData.filters.nha_cc = $scope.selectedProvider;
		}
		if($scope.spam_tinh_luong && jQuery.trim($scope.spam_tinh_luong)) {
			postData.filters.spam_tinh_luong = $scope.spam_tinh_luong;
		}
		if($scope.tinh_trang && jQuery.trim($scope.tinh_trang)) {
			postData.filters.tinh_trang = $scope.tinh_trang;
		}
		if($scope.co_hoa_don && jQuery.trim($scope.co_hoa_don)) {
			postData.filters.co_hoa_don = $scope.co_hoa_don;
		}
		if($scope.co_thiet_bi && jQuery.trim($scope.co_thiet_bi)) {
			postData.filters.co_thiet_bi = $scope.co_thiet_bi;
		}
		if($scope.ngayBatDau) {
			postData.filters.ngayBatDau = $scope.ngayBatDau;
		}
		if($scope.ngayKetThuc) {
			postData.filters.ngayKetThuc = $scope.ngayKetThuc;
		}
		if(usertype === 3) {
			postData.filters.id_nhan_vien_kinh_doanh = loginId;
		}
		ajax({
			url: BASE_REQUEST + '/Dtable/json?table=customer_thap2',
			data: postData,
			success: function(resp) {
				$scope.items = resp.rows;
				$scope.total = parseInt(resp.total);
				$scope.itemSelecteds = {};
				$scope.$apply();
			}
		});
	};

	$scope.reload();

	// chọn nhân viên kinh doanh
	$scope.selectSaleStaff = function() {
		$scope.search();
	};

	$scope.selectProvider = function() {
		$scope.search();
	};

	$scope.chonTinhTrang = function() {
		$scope.search();
	}

	$scope.chonCoHoaDon = function() {
		$scope.search();
	}

	$scope.chonCoThietBi = function() {
		$scope.search();
	}

	$scope.chonSpamTinhLuong = function() {
		$scope.search();
	}

	$scope.chonNgayBatDau = function() {
		console.log($scope.ngayBatDau);
		$scope.search();
	}

	$scope.chonNgayKetThuc = function() {
		console.log($scope.ngayKetThuc);
		$scope.search();
	}

	$scope.chonTruongSapXep = function() {
		$scope.search();
	}

	$scope.chonThuTuSapXep = function() {
		$scope.search();
	}

	// đổi trang (phân trang)
	$scope.changePage = function(page) {
		$scope.page = page;
		$scope.reload();
	};

	// danh sách các trang
	$scope.pages = function() {
		var pages = [];
		var totalPages = Math.ceil($scope.total / $scope.rows);
		for(var i = 1; i <= totalPages; i++) {
			if(i==1 || i== totalPages || (i < $scope.page + 5 && i > $scope.page - 5)) {
				pages.push(i);
			}
		}
		return pages;
	};

	// danh sách nhân viên kinh doanh
	$scope.loadSaleStaffs = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/json?table=staff',
			data: {
				rows: 100,
				page: 1,
				filters: {
					STAFF_TYPE: 3
				}
			},
			success: function(resp) {
				$scope.saleStaffs = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.loadSaleStaffs();

	// danh sách nhà cung cấp
	$scope.loadProviders = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/json?table=app_params',
			data: {
				rows: 1000,
				page: 1,
				filters: {
					PAR_TYPE: 'PROVIDER'
				}
			},
			success: function(resp) {
				$scope.providers = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.loadProviders();

	// chi tiết
	$scope.detail = function(item) {
		$scope.selectedItem = item;
	}
	$scope.mode = 'list';
	$scope.selectedItem = {id_nhan_vien_kinh_doanh: ''};
	$scope.edit = function(item) {
		$scope.mode = 'edit';
		$scope.selectedItem = item;
		$scope.chonNVKD();
	};
	
	// lưu khi edit
	$scope.save = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/'+$scope.mode+'?table=customer_thap2',
			data: $scope.selectedItem,
			success: function(resp) {
				$scope.mode = 'list';
				$scope.reload();
				alert('Đã lưu thành công');
			}
		});
	};
	$scope.addItem = {};

	$scope.add = function() {
		$scope.mode = 'add';
		$scope.resetAdd();
	};
	$scope.resetAdd = function() {
		$scope.selectedItem = {};
	};

	$scope.cancel = function() {
		$scope.mode = 'list';
		$scope.reload();
	}

	
	$scope.loadFields = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/fields?table=customer_thap2',
			success: function(resp) {
				$scope.fields = resp;
				$scope.$apply();
			}
		});
		
	};
	$scope.loadFields();

	$scope.exportConfig = {};

	$scope.export = function(type, export_set) {

		var exportOptions = {
			fields: []
		};
		
		if(!export_set) {
			for(var field in $scope.exportConfig.fields) {
				var fieldConfig = $scope.exportConfig.fields[field];
				fieldConfig.index = field;
				exportOptions.fields.push(fieldConfig);
			}
		}

		var postData = {
			export: type || $scope.exportConfig.type,
			export_set: export_set || 'default',
			page: 1,
			rows: 100000000,
			options: exportOptions,
			filters: {

			}
		};
		if($scope.keyword && jQuery.trim($scope.keyword) !== '') {
			postData.filters.keyword = jQuery.trim($scope.keyword);
		}
		if($scope.selectedSale) {
			postData.filters.id_nhan_vien_kinh_doanh = $scope.selectedSale.id;
		}
		if($scope.spam_tinh_luong && jQuery.trim($scope.spam_tinh_luong)) {
			postData.filters.spam_tinh_luong = $scope.spam_tinh_luong;
		}
		if($scope.tinh_trang && jQuery.trim($scope.tinh_trang)) {
			postData.filters.tinh_trang = $scope.tinh_trang;
		}
		if($scope.co_hoa_don && jQuery.trim($scope.co_hoa_don)) {
			postData.filters.co_hoa_don = $scope.co_hoa_don;
		}
		if($scope.co_thiet_bi && jQuery.trim($scope.co_thiet_bi)) {
			postData.filters.co_thiet_bi = $scope.co_thiet_bi;
		}
		if($scope.ngayBatDau) {
			postData.filters.ngayBatDau = $scope.ngayBatDau;
		}
		if($scope.ngayKetThuc) {
			postData.filters.ngayKetThuc = $scope.ngayKetThuc;
		}
		if(usertype === 3) {
			postData.filters.id_nhan_vien_kinh_doanh = loginId;
		}
		ajax({
			url: BASE_REQUEST + '/Dtable/json?table=customer_thap2',
			data: postData,
			success: function(resp) {
				var path= resp.file; 
    var save = document.createElement('a');  
    save.href = path; 
    save.download = 'thap.' + postData.export; 
    save.target = '_blank'; 
    document.body.appendChild(save);
    save.click();
				document.body.removeChild(save);
			}
		});
	}

	$scope.toggleSelectedItems = function() {
		$scope.itemSelecteds = {};
		for(var i = 0; i < $scope.items.length; i++) {
			var item = $scope.items[i];
			$scope.itemSelecteds[item.id] = $scope.checkAllItems;	
		}
	};

	$scope.chonNVKD = function() {
		var sale = null;
		var id_nhan_vien_kinh_doanh = $scope.selectedItem.id_nhan_vien_kinh_doanh;
		for(var i = 0; i < $scope.saleStaffs.length; i++) {
			var nvkd = $scope.saleStaffs[i];
			if(nvkd.id == id_nhan_vien_kinh_doanh) {
				sale = nvkd;
				break;
			}
		}
		$scope.selectedItem.id_nhan_vien_kinh_doanh = id_nhan_vien_kinh_doanh;
		$scope.selectedItem.nhan_vien_kinh_doanh = sale ? sale.NAME : '';
	};

	$scope.del = function() {
		if(confirm('Bạn có muốn xóa những bản ghi đã chọn?')) {
			var ids = [];
			for(var id in $scope.itemSelecteds) {
				if($scope.itemSelecteds[id]) {
					ids.push(id);
				}
			}
			ajax({
				url: BASE_REQUEST + '/Dtable/del?table=customer_thap2',
				data: {
					ids: ids
				},
				success: function() {
					$scope.reload();
				}
			});
		}
	}
}]);

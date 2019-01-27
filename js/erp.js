erpApp = angular.module('erpApp', ["ngSanitize"]);

erpApp.config(function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

erpApp.filter('vndate', function() {
	return function(input) {
			input = input || '';
			var out = '';
			var tmp = input.split('-');
			out = tmp[2] + '/' + tmp[1] + '/' + tmp[0];
			return out;
	};
});

erpApp.controller('thapController', ['$scope', function($scope) {
	$scope.keyword = "";
	$scope.all_rows = [10, 20, 50, 100, 200];
	$scope.search = function() {
		$scope.reload();
	};
	$scope.rows = 50;
	$scope.page = 1;
	$scope.total = 0;
	$scope.reload = function() {
		var postData = {
			rows: $scope.rows,
			page: $scope.page,
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
		if(usertype === 3) {
			postData.filters.id_nhan_vien_kinh_doanh = loginId;
		}
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=customer_thap2',
			type: 'post',
			data: postData,
			dataType: 'json',
			success: function(resp) {
				$scope.items = resp.rows;
				$scope.total = parseInt(resp.total);
				$scope.itemSelecteds = {};
				$scope.$apply();
			}
		});
	};

	$scope.selectSaleStaff = function() {
		// console.log($scope.selectedSale);
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

	$scope.changePage = function(page) {
		$scope.page = page;
		$scope.reload();
	};

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

	$scope.detail = function(item) {
		$scope.selectedItem = item;
	}

	$scope.reload();

	$scope.loadSaleStaffs = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=staff',
			type: 'post',
			data: {
				rows: 100,
				page: 1,
				filters: {
					STAFF_TYPE: 3
				}
			},
			dataType: 'json',
			success: function(resp) {
				$scope.saleStaffs = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.loadSaleStaffs();
	$scope.save = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/edit?table=customer_thap2',
			type: 'post',
			dataType: 'json',
			data: $scope.selectedItem,
			success: function(resp) {
				$scope.$apply();
				console.log(resp);
				alert('Đã lưu thành công');
			}
		});
	};
	$scope.addItem = {};

	$scope.add = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/add?table=customer_thap2',
			type: 'post',
			dataType: 'json',
			data: $scope.addItem,
			success: function(resp) {
				console.log(resp);
				alert('Đã thêm thành công');
			}
		});
	};
	$scope.resetAdd = function() {
		$scope.addItem = {};
	};

	
	$scope.loadFields = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/fields?table=customer_thap2',
			type: 'post',
			dataType: 'json',
			success: function(resp) {
				$scope.fields = resp;
				$scope.$apply();
			}
		});
		
	};
	$scope.loadFields();

	$scope.exportConfig = {};

	$scope.export = function() {
		var exportOptions = {
			fields: []
		};
		for(var field in $scope.exportConfig.fields) {
			var fieldConfig = $scope.exportConfig.fields[field];
			fieldConfig.index = field;
			exportOptions.fields.push(fieldConfig);
		}
		var postData = {
			export: $scope.exportConfig.type,
			export_set: 'default',
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
		if(usertype === 3) {
			postData.filters.id_nhan_vien_kinh_doanh = loginId;
		}
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=customer_thap2',
			type: 'post',
			dataType: 'json',
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
}]);




erpApp.controller('phanquyenController', ['$scope', function($scope) {
	$scope.loadStaffTypes = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=app_params',
			type: 'post',
			dataType: 'json',
			data: {
				rows: 100,
				page: 1,
				filters: {
					PAR_TYPE: 'STAFF_TYPE'
				}
			},
			success: function(resp) {
				$scope.staffTypes = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.loadStaffTypes();

	$scope.loadDepartments = function() {
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=department',
			type: 'post',
			dataType: 'json',
			data: {
				rows: 100,
				page: 1,
				filters: {
					STATUS: 1
				}
			},
			success: function(resp) {
				$scope.departments = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.loadDepartments();

	$scope.selectDepartment = function(dept) {
		$scope.selectedDepartment = dept;
		$scope.loadStaffs();
	};

	$scope.selectStaffType = function(item) {
		$scope.selectedStaffType = item;
		$scope.loadStaffs();
	};

	// load all staffs
	$scope.loadStaffs = function() {
		$scope.mode = '';
		var filters = {};
		if($scope.selectedStaffType) {
			filters.STAFF_TYPE = $scope.selectedStaffType.PAR_CODE;
		}

		if($scope.selectedDepartment) {
			filters.DEPT_ID = $scope.selectedDepartment.id;
		}
		
		jQuery.ajax({
			url: BASE_REQUEST + '/Dtable/json?table=staff',
			type: 'post',
			dataType: 'json',
			data: {
				rows: 100,
				page: 1,
				filters: filters
			},
			success: function(resp) {
				$scope.staffs = resp.rows;
				$scope.$apply();
			}
		});
	};
	$scope.mode = '';

	// edit staff
	$scope.editStaff = function(staff) {
		$scope.mode = 'editStaff';
		$scope.selectedStaff = staff;
	}

	// update staff
	$scope.updateStaff = function() {
		// TODO: Update staff
	}

	// add staff
	$scope.addStaff = function() {
		$scope.mode = 'addStaff';
	}

	$scope.insertStaff = function() {
		// TODO: Insert staff
	}
}]);
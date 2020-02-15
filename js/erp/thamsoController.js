erpApp.controller('thamsoController', ['$scope', function($scope) {
	// load data for filters
	$scope.loadTypes = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/distinct?table=app_params',
			data: {
				field: 'PAR_TYPE'
			},
			success: function(resp) {
				$scope.types = resp;
				$scope.$apply();
			}
		});
	};
	
	$scope.loadTypes();
	
	// filters
	$scope.chonType = function() {
		$scope.reload();
	}
	$scope.chonStatus = function() {
		$scope.reload();
	}
	$scope.search = function() {
		$scope.reload();
	};

	// list
	$scope.keyword = "";
	$scope.all_rows = [10, 20, 50, 100, 200];
	$scope.rows = 50;
	$scope.page = 1;
	$scope.total = 0;

	$scope.reload = function() {
		var postData = {
			rows: $scope.rows,
			page: $scope.page,
			filters: {
				keyword: $scope.keyword
			},
			sort: 'PAR_TYPE,PAR_ORDER',
			order:'asc,asc'
		};
		if($scope.keyword && jQuery.trim($scope.keyword) !== '') {
			postData.filters.keyword = jQuery.trim($scope.keyword);
		}
		if($scope.selectedType) {
			postData.filters.PAR_TYPE = $scope.selectedType;
		}
		if($scope.STATUS && jQuery.trim($scope.STATUS) !== '') {
			postData.filters.STATUS = $scope.STATUS;
		}

		ajax({
			url: BASE_REQUEST + '/Dtable/json?table=app_params',
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

	// add, edit, cancel
	$scope.mode = 'list';
	$scope.edit = function(item) {
		$scope.mode = 'edit';
		$scope.selectedItem = item;
	};
	
	// lưu khi edit
	$scope.save = function() {
		ajax({
			url: BASE_REQUEST + '/Dtable/'+$scope.mode+'?table=app_params',
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
	};

}]);
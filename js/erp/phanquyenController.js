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
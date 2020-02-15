erpApp = angular.module('erpApp', ["ngSanitize"]);

erpApp.config(function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

erpApp.directive('jqdatepicker', function() {
	return {
		restrict: 'A',
		require: 'ngModel',
		link: function(scope, element, attrs, ctrl) {
	jQuery(element).datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function(date) {
			//var s = date.split('-');
			//var dateValue = s[2] + '/' + s[1] + '/' + s[0];
			ctrl.$setViewValue(date);
			ctrl.$render();
			scope.$apply();
		}
	});
	jQuery(element).datepicker( "option", jQuery.datepicker.regional[ 'vn' ]);
		}
	};
});

erpApp.directive('fileModel', ['$parse', function ($parse) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var model = $parse(attrs.fileModel);
			var modelSetter = model.assign;
			
			element.bind('change', function() {
				scope.$apply(function() {
					modelSetter(scope, element[0].files[0]);
				});
			});
		}
	};
}]);

erpApp.service('fileUpload', ['$http', function ($http) {
	this.uploadFileToUrl = function(file, uploadUrl, success, err) {
		var fd = new FormData();
		fd.append('file', file);
	
		$http.post(uploadUrl, fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		})
		.then(function(resp) {
			// success
			if(typeof success !== 'undefined')
				success(resp);
		}, function(resp) {
			// error
			if(typeof err !== 'undefined')
				err(resp);
		});
	}
}]);

erpApp.filter('co_hd', function() {
	return function(input) {
	input = input || '';
	var out = '';
	out = input == '0' ? 'Không hóa đơn': 'Có hóa đơn';
	return out;
	};
});

erpApp.filter('ht_hd_tb', function() {
	return function(input) {
	input = input || '';
	var out = '';
	out = input == '0' ? 'Chưa hoàn thành': 'Đã hoàn thành';
	return out;
	};
});

erpApp.filter('co_tb', function() {
	return function(input) {
	input = input || '';
	var out = '';
	out = input == '0' ? 'Không thiết bị': 'Có thiết bị';
	return out;
	};
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

erpApp.filter('vnprice', function() {
	return function(input) {
	input = input || '';
	var out = '';
	input = parseFloat(input);
	out = input.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
	return out;
	};
});

erpApp.filter('status', function() {
	return function(input) {
	input = input || '';
	var out = '';
	input = parseInt(input);
	out = input == 0 ? 'Chưa kích hoạt': 'Đã kích hoạt';
	return out;
	};
});

function ajax(options) {
	options.type = 'post';
	options.dataType = 'json';
	return jQuery.ajax(options);
}

pzk.loadScript('/js/upload.js');
var d = new Date();
var t = ''+ d.getFullYear() +''+ (d.getMonth()+1) +''+ d.getDate() +''+ d.getHours();
pzk.loadScript('/js/erp/thapController.js?t=' + t);
pzk.loadScript('/js/erp/phanquyenController.js?t=' + t);
pzk.loadScript('/js/erp/thamsoController.js?t=' + t);
pzk.loadScript('/js/erp/khachhangController.js?t=' + t);

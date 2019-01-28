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

pzk.loadScript('/js/erp/thapController.js');
pzk.loadScript('/js/erp/phanquyenController.js');
pzk.loadScript('/js/erp/thamsoController.js');
Function.prototype.pzkImpl = function(props) {
	this.prototype = $.extend(this.prototype || {}, props);
	return this;
};

Function.prototype.pzkExt = function(props) {
	var that = this;
	var func = function() {that.apply(this, arguments);};
	func.prototype = $.extend({}, this.prototype || {}, props);
	return func;
};

String.pzkImpl({
	ucfirst: function() {
		return this.substr(0, 1).toUpperCase() + this.substr(1);
	}
});

/**
	* Source: https://stackoverflow.com/questions/1714786/query-string-encoding-of-a-javascript-object
 */
serializeURI = function(obj, prefix) {
	var str = [],
			p;
	for (p in obj) {
			if (obj.hasOwnProperty(p)) {
					var k = prefix ? prefix + "[" + p + "]" : p,
							v = obj[p];
					str.push((v !== null && typeof v === "object") ?
							serializeURI(v, k) :
							encodeURIComponent(k) + "=" + encodeURIComponent(v));
			}
	}
	return str.join("&");
}

jQuery.fn.serializeForm = function() {
	var arr = this.serializeArray();
	var rslt = {};
	for(var i = 0; i < arr.length; i++) {
		var elem = arr[i];
		if (elem.name.indexOf('[') ==-1) {
			rslt[elem.name] = elem.value;
		} else {
			elem.name = elem.name.replace(/\]\[/g, '.');
			elem.name = elem.name.replace(/\[/g, '.');
			elem.name = elem.name.replace(/\]/g, '');
			var parts = elem.name.split('.');
			var cur = rslt;
			for(var j = 0; j < parts.length - 1; j++){
				var part = parts[j];
				if (typeof cur[part] == 'undefined') cur[part] = {};
				cur = cur[part];
			}
			cur[parts[parts.length-1]] = elem.value;
		}
	}
	return rslt;
};

jQuery.fn.pzkVal = function(val) {
	if(typeof val === 'undefined') {
		if(this.hasClass('easyui-combobox')) {
			return this.combobox('getValue');
		} else {
			return this.val();
		}
	} else {
		if(this.hasClass('easyui-combobox')) {
			return this.combobox('setValue', val);
		} else {
			return this.val(val);
		}
	}
	
};

jQuery.fn.pzkTemplate = function(data) {
	for(var k in data) {
		var elem = this.find('.pzk-field-' + k);
		if(elem.is('input,select')) {
			elem.pzkVal(data[k]);
		} else {
			elem.html(data[k]);
		}
	}
};

pzk = {
	page: 'index',
	elements: {},
	loadScript: function(jsFile) {
		var $head = $('body');
		if ($head.find('script[src="'+jsFile+'"]').length == 0) {
			$head.append('<script src="'+jsFile+'"></script>');
		}
	},
	loadLink: function(cssFile) {
		var $head = $('body');
		if ($head.find('link[href='+cssFile+']').length == 0) {
			$head.append('<link rel="stylesheet" href="'+cssFile+'"></link>');
		}
	},
	ajax: function(options, success) {
		options.type = 'post';
		options.dataType = 'json';
		if(typeof success !== 'undefined') {
			options.success = success;
		}
		$.ajax(options);
	},
	db: {
		add: function(table, data, success) {
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/add?table=' + table,
				data: data
			}, success);
		},
		edit: function(table, data, success) {
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/edit?table=' + table,
				data: data
			}, success);
		},
		update: function(table, data, success) {
			data.noConstraint = false;
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/update?table=' + table,
				data: data
			}, success);
		},
		replace: function(table, data, success) {
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/replace?table=' + table,
				data: data
			}, success);
		},
		del: function(table, data, success) {
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/del?table=' + table,
				data: data
			}, success);
		},
		get: function(table, id, success) {
			pzk.ajax({
				url: BASE_REQUEST + '/Dtable/get?table=' + table,
				data: {
					id: id
				}
			}, success);
		}
	},
	remote: {
		list: function(model, params, success) {
			$.ajax({
				url: 'http://api2.nextnobels.com/' + model + '?' + serializeURI(params),
				type: 'get',
				dataType: 'json',
				success: success
			});
		}
	}
	
};
PzkObj = (function(props) { $.extend (this, props || {}); }).pzkImpl({
	init: function() {
	},
	execute: function(task, data) {
		this['do' + task.ucfirst()](data);
	},
	$: function(selector) {
		if (typeof selector == 'undefined') return $('#' + this.id);
		return $(selector, '#' + this.id);
	},
	toJson: function() {
		var rs = {};
		for(var k in this) {
			if ((typeof this[k] != 'function') && (typeof this[k] != 'object')) {
				rs[k] = this[k];
			}
		}
		return rs;
	},
	reload: function() {
	}
});

PzkController = function(props) {$.extend (this, props || {});}; 

function pzk_init(instances) {
	for(var i = 0; i < instances.length;i++) {
		var props = instances[i];
		var inst = null;
		eval('inst = new ' + props['className'].ucfirst() + '(props);');
		pzk.elements[inst.id] = inst;
		inst.init(); 
	}
}

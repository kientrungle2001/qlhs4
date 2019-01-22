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

pzk = {
	page: 'index',
	elements: {},
	loadScript: function(jsFile) {
		var $head = $('body');
		if ($head.find('script[src='+jsFile+']').length == 0) {
			$head.append('<script src="'+jsFile+'"></script>');
		}
	},
	loadLink: function(cssFile) {
		var $head = $('body');
		if ($head.find('link[href='+cssFile+']').length == 0) {
			$head.append('<link rel="stylesheet" href="'+cssFile+'"></link>');
		}
	},
	ajax: function(options) {
		options.data.mainPage = pzk.page;
		$.ajax(options);
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

var pzks = {};
function registerService(url) {
	var names = url.split('/');
	pzks[names[0]] = pzks[names[0]] || {};
	pzks[names[0]][names[1]] = function(params, callback) {
		jQuery.ajax({
			url: BASE_REQUEST + '/' + url,
			data: params,
			type: 'post',
			dataType: 'json',
			success: function(resp) {
				callback(resp);
			}
		});
	}
}

registerService('dtable/json');

pzks.dtable.student = function(options, callback) {
	var opts = jQuery.extend({}, options, {
		table: 'student'
	});
	return pzks.dtable.json(opts, callback);
}

pzks.dtable.student.search = function(keyword, callback) {
	return pzks.dtable.student({
		page: 1, rows: 10, 
		filters: {
			keyword: keyword
		}
	}, callback);
}

pzks.dtable.teacher = function(options, callback) {
	var opts = jQuery.extend({}, options, {
		table: 'teacher'
	});
	return pzks.dtable.json(opts, callback);
}

pzks.dtable.teacher.search = function(keyword, callback) {
	return pzks.dtable.teacher({
		page: 1, rows: 10, 
		filters: {
			keyword: keyword
		}
	}, callback);
}

pzks.dtable.employee = function(options, callback) {
	var opts = jQuery.extend({}, options, {
		table: 'employee'
	});
	return pzks.dtable.json(opts, callback);
}

pzks.dtable.employee.search = function(keyword, callback) {
	return pzks.dtable.employee({
		page: 1, rows: 10, 
		filters: {
			keyword: keyword
		}
	}, callback);
}

pzks.dtable.partner = function(options, callback) {
	var opts = jQuery.extend({}, options, {
		table: 'partner'
	});
	return pzks.dtable.json(opts, callback);
}

pzks.dtable.partner.search = function(keyword, callback) {
	return pzks.dtable.partner({
		page: 1, rows: 10, 
		filters: {
			keyword: keyword
		}
	}, callback);
}

pzks.dtable.classes = function(options, callback) {
	var opts = jQuery.extend({}, options, {
		table: 'classes'
	});
	return pzks.dtable.json(opts, callback);
}

pzks.dtable.classes.search = function(keyword, callback) {
	return pzks.dtable.classes({
		page: 1, rows: 10, 
		filters: {
			keyword: keyword
		}
	}, callback);
}

jQuery.fn.pzkAutoComplete = function(options) {
	var defaultOptions = {
		items: [],
		matcher: function(item, word) {
			return item.toLowerCase().indexOf(word.toLowerCase()) !== -1;
		},
		render: function(item) {
			return item;
		},
		loader: function(word, callback) {
			(function(){})(word);
			callback(opts.items);
		},
		onSelect: function(item, $elem) {
			
		}
	};
	var opts = jQuery.extend({}, defaultOptions, options || {});
	var methods = {
		render_list: function() {
			list.html('');
			var word = $elem.val();
			opts.loader(word, function(items){
				items.forEach(function(item){
					if(opts.matcher(item, word)) {
						var $row = $('<a class="pzk-autocomplete-item" href="#"></a>');
						var renderedItem = opts.renderLabel(item);
						$row.text(renderedItem);
						$row.data('item', item);
						$row.click(function() {
							var r = $(this);
							var rItem = r.data('item');
							var rRenderedItem = opts.renderValue(rItem);
							$elem.val(rRenderedItem);
							methods.hide_list();
							opts.onSelect(rItem, $elem);
							return false;
						});
						list.append($row);
					}
				});
			});
			
		},
		hide_list: function() {
			autocomplete.hide();
		},
		show_list: function() {
			autocomplete.css({
				border: '1px solid #ddd',
				padding: 5
			});
			autocomplete.css({
				/*
				width: $elem.width() 
						- parseInt(autocomplete.css('padding-left')) 
						- parseInt(autocomplete.css('padding-right'))
						+ parseInt($elem.css('border-left'))
						+ parseInt($elem.css('border-right'))
						//- parseInt(autocomplete.css('border-left'))
						//- parseInt(autocomplete.css('border-right'))
						,
				*/
				top: $elem.offset().top 
						+ $elem.height()
						+ parseInt($elem.css('padding-top'))
						+ parseInt($elem.css('padding-bottom'))
						+ parseInt($elem.css('border-top'))
						+ parseInt($elem.css('border-bottom'))
				,
				left: $elem.offset().left - parseInt($elem.css('border-left'))
			});
			autocomplete.show();
		}
	};

	var $elem = this;
	
	$elem.after(
		`<div class="pzk-autocomplete">
			<a href="#" class="pzk-autocomplete-close">x</a>
			<div class="pzk-autocomplete-list"></div>
		</div>`
	);
	
	var autocomplete = $elem.next('.pzk-autocomplete');
	autocomplete.hide();
	var closeBtn = autocomplete.find('.pzk-autocomplete-close');
	closeBtn.click(function() {
		methods.hide_list();
	});
	var list = autocomplete.find('.pzk-autocomplete-list');
	list.html('');
	$elem.keyup(function(evt) {
		console.log(evt.keyCode);
		// keycode = up, down
		// keycode = esc
		// keycode = enter
		if(evt.keyCode === 40) {
			console.log('down');
			methods.show_list();
			return false;
		} else if(evt.keyCode == 38) {
			console.log('up');
			methods.show_list();
			return false;
		} else if(evt.keyCode == 13) {
			methods.hide_list();
			return false;
		} else if(evt.keyCode == 27) {
			methods.hide_list();
			return false;
		}
		methods.render_list();
		methods.show_list();
	});
	$elem.focus(function(evt) {
		methods.show_list();
	});
	$(document).click(function(evt) {
		if(evt.target == $elem[0]) return false;
		methods.hide_list();
	});
};
PzkEasyuiDatagridExport = PzkObj.pzkExt({
	startOver: function() {
		var tabs = jQuery('#tabs-'+this.id);
		tabs.tabs('select', 0);
		var result = jQuery('#result-'+this.id);
		result.html('Nhấn nút hoàn thành để bắt đầu');
	},
	startExport: function() {
		var tabs = jQuery('#tabs-'+this.id);
		tabs.tabs('select', 3);
		var result = jQuery('#result-'+this.id);
		result.html('Đang export...');
		/*
		var item = this.item;
		var fieldsJQuery = this.getFieldsJQuery();
		var fields = [];
		for (var field in item) {
			var checked = fieldsJQuery.find('[name="selected['+field+']"]')[0].checked;
			if(checked) {
				var fieldOptions = {};
				fieldOptions.index = field;
				fieldOptions.title = fieldsJQuery.find('[name="title['+field+']"]').val();
				fieldOptions.map = fieldsJQuery.find('[name="map['+field+']"]').val();
				fields.push(fieldOptions);
			}
		}
		*/
		var exportOptions = this.getExportOptions();
		console.log(exportOptions);
		var grid = this.getGrid();
		var type = jQuery('#tabs-' + this.id).find('[name=type]').val();
		var range = jQuery('#tabs-' + this.id).find('[name=range]').val();
		if(range === 'search') {
			var searchOptions = window[this.searchOptions];
			var options = searchOptions();
			options.options = exportOptions;
			grid.export(options, type, function(){
				result.html('Đã export xong');
			});
		} else {
			grid.export({
				options: exportOptions
			}, type, function(){
				result.html('Đã export xong');
			});
		}
		
	},
	getExportOptions: function() {
		var that = this;
		var exportConfig = this.getExportConfig();
		var mainOptions = this.getTableOptions(this.table);
		mainOptions.childTables = [];
		exportConfig.childTables.forEach(function(childConfig){
			if(that.isSelectedTable(childConfig.table)) {
				var childOptions = that.getTableOptions(childConfig.table);
				childOptions = jQuery.extend(childOptions, childConfig);
				mainOptions.childTables.push(childOptions);
			}
		});
		return mainOptions;
	},
	isSelectedTable: function(table) {
		var fieldsJQuery = this.getFieldsJQuery();
		var checked = fieldsJQuery.find('[name="table_selected['+table+']"]')[0].checked;
		return checked;
	},
	getTableOptions: function(table) {
		var options = {};
		var fieldsJQuery = this.getFieldsJQuery();
		var fields = [];
		var tableFields = this.getFields(table);
		tableFields.forEach( function(field) {
			var checked = fieldsJQuery.find('[name="selected['+table+']['+field+']"]')[0].checked;
			if(checked) {
				var fieldOptions = {};
				fieldOptions.index = field;
				fieldOptions.title = fieldsJQuery.find('[name="title['+table+']['+field+']"]').val();
				fieldOptions.map = fieldsJQuery.find('[name="map['+table+']['+field+']"]').val();
				fields.push(fieldOptions);
			}
		}
		);
		options.fields = fields;
		return options;
	},
	next: function() {
		var tabs = jQuery('#tabs-'+this.id);
		var index = this.getCurrentIndex();
		if(index < 3)
			tabs.tabs('select', index+1);
	},
	prev: function() {
		var tabs = jQuery('#tabs-'+this.id);
		var index = this.getCurrentIndex();
		if(index > 0)
			tabs.tabs('select', index-1);
	},
	onSelect: function() {

	},
	getCurrentIndex: function() {
		var tabs = jQuery('#tabs-'+this.id);
		var tab = tabs.tabs('getSelected');
		var index = tabs.tabs('getTabIndex',tab);
		return index;
	},
	init: function() {
		this.initExtraExportFields();
	},
/**
Lấy ra cấu hình export
Lấy dữ liệu các trường của bảng chính
Hiển thị cấu hình cho bảng chính
Lấy dữ liệu các trường của bảng con
Hiển thị cấu hình cho bảng con
*/
	initExtraExportFields: function() {
		var that = this;
		that.getFieldsJQuery().html('');
		var config = that.getExportConfig(that.table);
		var fields = that.getFields(that.table);
		that.renderMainFields(that.table, fields);
		config.childTables.forEach(function(childConfig){
			var childFields = that.getFields(childConfig.table);
			that.renderFields(childConfig.table, childFields);
		});
	},
	getExportConfig: function() {
		if(!this._config) {
			var config = {};
			$.ajax({
				async: false,
				url: BASE_REQUEST + '/dtable/exportConfig?table=' + this.table,
				dataType: 'json',
				type: 'post',
				success: function(resp) {
					config = resp;
				}
			});
			this._config = config;
		}
		
		return this._config;
	},
	getFields: function(table) {
		var fields = [];
		$.ajax({
			async: false,
			url: BASE_REQUEST + '/dtable/fields?table=' + table,
			dataType: 'json',
			type: 'post',
			success: function(resp) {
				fields = resp;
			}
		});
		return fields;
	},
	renderMainFields: function(table, fields) {
		var that = this;
		var fieldTable = '';
		fieldTable += '<h2>'+(table !== this.table ? '<input type="checkbox" name="table_selected['+table+']" value="1" checked />':'')+' Export Table ' + table + '</h2>';

		fieldTable += `<table border="1" style="border-collapse: collapse; width: 100%;"><tr>`;
			
		fields.forEach(function(field){
			fieldTable += `<th>`+field+`</th>`;
		});
		
		fieldTable += `</tr><tr>`;
		
		fields.forEach(function(field){
			fieldTable += `<td><input type="checkbox" checked="checked" name="selected[`+table+`][`+field+`]" /></td>`;
		});
		
		fieldTable += `</tr><tr>`;

		fields.forEach(function(field){
			fieldTable += `<td><input type="text" placeholder="title for `+field+`" name="title[`+table+`][`+field+`]" /></td>`;
		});
		
		fieldTable += `</tr><tr>`;
		
		fields.forEach(function(field){
			fieldTable += `<td><textarea placeholder="map for `+field+`" name="map[`+table+`][`+field+`]"></textarea></td>`;
		});
			
		fieldTable += `</tr></table>`;
		that.getFieldsJQuery().append(fieldTable);
	},
	renderFields: function(table, fields) {
		this.renderMainFields(table, fields);
	},
	initExportFields: function() {
		var that = this;
		var grid = this.getGrid();
		grid.getRows({}, function(resp){
			var item = resp.rows[0];
			that.item = item;
			var fieldTable = `<table border="1" style="border-collapse: collapse; width: 100%;">
			<tr>`;
			for(var field in item) {
				fieldTable += `<th>`+field+`</th>`;
			}
			
			fieldTable += `</tr>
			<tr>`;
			for(var field in item) {
				fieldTable += `<td><input type="checkbox" checked="checked" name="selected[`+field+`]" /></td>`;
			}
			fieldTable += `</tr><tr>`;
			for(var field in item) {
				fieldTable += `<td><input type="text" placeholder="title for `+field+`" name="title[`+field+`]" /></td>`;
			}
			fieldTable += `</tr><tr>`;
			for(var field in item) {
				fieldTable += `<td><textarea placeholder="map for `+field+`" name="map[`+field+`]"></textarea></td>`;
			}
				
			fieldTable += `</tr></table>`;
			that.getFieldsJQuery().html(fieldTable);
		});
	},
	getGrid: function() {
		return pzk.elements[this.gridId];
	},
	getFieldsJQuery: function() {
		return $('#fields-'+this.id);
	}
});
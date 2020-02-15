PzkEasyuiDatagridImport = PzkObj.pzkExt({
	init: function() {
		var that = this;
		var $fileUpload = $('#file-' + this.id);
		$fileUpload.change(function(evt){
			var file    = evt.target.files[0];
			var reader  = new FileReader();

			reader.addEventListener("load", function () {
				var items = [];
				var str = reader.result;
				var lines = str.split(/\r\n|\r|\n/g);
				lines.forEach(function(line, index) {
					if(index > 20) return false;
					try {
						var item = JSON.parse(line);
						items.push(item);
					} catch(err) {
						console.log(err);
					}
				});
				console.log(items);
				that.sampleItems = items;
				that.next();
				that.previewImport();
			}, false);

			if (file) {
					reader.readAsText(file);
			}
		});
	},
	startOver: function() {
		var tabs = jQuery('#tabs-'+this.id);
		tabs.tabs('select', 0);
		var result = jQuery('#result-'+this.id);
		result.html('Nhấn nút hoàn thành để bắt đầu');
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
	getCurrentIndex: function() {
		var tabs = jQuery('#tabs-'+this.id);
		var tab = tabs.tabs('getSelected');
		var index = tabs.tabs('getTabIndex',tab);
		return index;
	},
	getGrid: function() {
		return pzk.elements[this.gridId];
	},
	getFieldsJQuery: function() {
		return $('#fields-'+this.id);
	},
	previewImport: function() {
		var that = this;
		var grid = this.getGrid();
		grid.getRows({}, function(resp){
			var gridItem = resp.rows[0];
			var item = that.sampleItems[0];
			that.item = item;
			var fieldTable = `
			<select name="importType">
				<option value="update">Cập nhật dữ liệu</option>
				<option value="insert">Thêm dữ liệu</option>
			</select>
			<table border="1" style="border-collapse: collapse; width: 100%;">
				<tr>`;

				for(var field in item) {
					fieldTable += `<th><input type="checkbox" checked="checked" name="selected[`+field+`]" />`+field+`</th>`;
				}
				fieldTable += `</tr><tr>`;
				for(var field in item) {
					fieldTable += `<th><select name="gridFields[`+field+`]">`;
					for(var gridField in gridItem) {
						fieldTable += `<option value="`+gridField+`" `+(gridField == field ? 'selected': '')+`>`+gridField+`</option>`;
					}
					fieldTable += `</select></th>`;
				}
				fieldTable += `</tr><tr>`;
				for(var field in item) {
					fieldTable += `<td><input type="checkbox" name="key[`+field+`]" />Khóa chính</td>`;
				}
				fieldTable += `</tr><tr>`;
				for(var field in item) {
					fieldTable += `<td><textarea placeholder="map for `+field+`" name="map[`+field+`]"></textarea></td>`;
				}
				fieldTable += `</tr></table>`;
				that.getFieldsJQuery().html(fieldTable);
		});
	},
	startImport: function() {
		var tabs = jQuery('#tabs-'+this.id);
		tabs.tabs('select', 2);
		var options = this.getImportOptions();
		console.log(options);
		this.import(options);
	},
	getImportOptions: function() {
		var item = this.item;
		var fields = [];
		var keys = [];
		
		var fieldsJQuery = this.getFieldsJQuery();
		var importType = fieldsJQuery.find('[name=importType]').val();

		for (var field in item) {
			var checked = fieldsJQuery.find('[name="selected['+field+']"]')[0].checked;
			if(checked) {
				var fieldOptions = {};
				fieldOptions.index = field;
				fieldOptions.toindex = fieldsJQuery.find('[name="gridFields['+field+']"]').val();
				fieldOptions.map = fieldsJQuery.find('[name="map['+field+']"]').val();
				fields.push(fieldOptions);
			}
		}
		for (var field in item) {
			var checked = fieldsJQuery.find('[name="key['+field+']"]')[0].checked;
			if(checked) {
				keys.push(field);
			}
		}
		return {
			fields: fields,
			importType: importType,
			keys: keys
		};
	},
	import: function(options) {
		var that = this;
		$('#result-' + that.id).html('');
		this.getImportData(function(items){
			items.forEach(function(item){
				var processedItem = that.processsImportItem(item, options);
				that.runImportAction(processedItem, options);
			});
			that.getGrid().reload();
		});
	},
	getImportData: function(callback) {
		var $fileUpload = $('#file-' + this.id);
		(function(){
			var file    = $fileUpload[0].files[0];
			var reader  = new FileReader();

			reader.addEventListener("load", function () {
				var items = [];
				var str = reader.result;
				var lines = str.split(/\r\n|\r|\n/g);
				lines.forEach(function(line, index) {
					try {
						var item = JSON.parse(line);
						items.push(item);
					} catch(err) {
						console.log(err);
					}
				});
				console.log(items);
				callback(items);
			}, false);

			if (file) {
					reader.readAsText(file);
			}
		})();
	},
	processsImportItem: function(item, options) {
		var result = {};
		for(var i = 0; i < options.fields.length;i++) {
			var fieldOptions = options.fields[i];
			result[fieldOptions.toindex] = item[fieldOptions.index];
		}
		return result;
	},
	runImportAction: function(item, options) {
		if(options.importType == 'insert') {
			this.runInsert(item, options)
		} else {
			this.runUpdate(item, options);
		}
	},
	runUpdate: function(item, options) {
		var that = this;
		$.ajax({
			async: false,
			url: BASE_REQUEST + '/dtable/import?type=update&table=' + that.table,
			type: 'post',
			dataType: 'json',
			data: {
				item: item,
				options: options
			},
			success: function(resp) {
				$('#result-' + that.id).append('<div style="text-align: left;border-bottom: 1px solid #ddd;padding: 10px;">Imported item: '+JSON.stringify(item)+'</div>');
			}
		});
	},
	runInsert: function(item, options) {
		var that = this;
		$.ajax({
			async: false,
			url: BASE_REQUEST + '/dtable/import?type=insert&table=' + that.table,
			type: 'post',
			dataType: 'json',
			data: {
				item: item,
				options: options
			},
			success: function(resp) {
				$('#result-' + that.id).append('<div style="text-align: left;border-bottom: 1px solid #ddd;padding: 10px;">Imported item: '+JSON.stringify(item)+'</div>');
			}
		});
	}
});
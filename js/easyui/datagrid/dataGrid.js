/**
 * Lớp mô tả đối tượng datagrid
 * @author Le Trung Kien
 * @version 1.0
 * @since 2013
 * 
 */
PzkEasyuiDatagridDataGrid = PzkObj.pzkExt({
	/**
	 * Hàm khởi tạo, chạy ngay sau khi đối tượng được tạo ra 
	 */
	init: function() {
	},
	/**
	 * Chuyển chế độ sang chế độ thêm. Thường dùng khi bấm nút thêm
	 * @example pzk.elements.dg.addMode().add()
	 * @returns PzkEasyuiDatagridDataGrid
	 */
	addMode: function() {
		this.url = BASE_URL + '/index.php'+this.controller+'/add?table=' + this.table;
		this.saveMode = 'add';
		return this;
	},
	/**
	 * Chuyển chế độ sang chế độ sửa. Thường dùng khi bấm nút sửa
	 * @example pzk.elements.dg.editMode().edit()
	 * @returns PzkEasyuiDatagridDataGrid
	 */
	editMode: function() {
		this.url = BASE_URL + '/index.php'+this.controller+'/edit?table=' + this.table;
		this.saveMode = 'edit';
		return this;
	},
	/**
	 * Bật form thêm/sửa, clear dữ liệu ở form đi
	 * Đặt lại url thêm dữ liệu
	 */
	add: function(data) {
		this.saveMode = 'add';
		$('#dlg-' + this.id).dialog('open');
		$('#fm-' + this.id).form('clear');

		// Nếu có data thì set data cho form add
		if(typeof data !== 'undefined') {
			$('#fm-' + this.id).form('load', data);
		}
		
		// set lại url
		this.url = BASE_URL + '/index.php'+this.controller+'/add?table=' + this.table;

		// nếu có trường multiselect
		if(this.multiselects) {
			var multiselects = this.multiselects.split(',');
			for(var i = 0; i < multiselects.length; i++) {
				var field = multiselects[i];
				var selecteds = row[field].split(',');
				$('#' + field).find('option').attr('selected', false);
			}
		}

		// nếu có trường fckeditor
		if(this.fckeditors) {
			var fckeditors = this.fckeditors.split(',');
			for(var i = 0; i < fckeditors.length; i++) {
				var field = fckeditors[i];
				FCKeditorAPI.Instances[field].SetData('<p></p>');
			}
			
		}
	},
	/**
	 * Bật form thêm/sửa, load dữ liệu từ bản ghi đang chọn vào form
	 * Đặt lại url sửa dữ liệu
	 */
	edit: function() {
		this.saveMode = 'edit';
		var row = $('#' + this.id).datagrid('getSelected');
		if (row){
			$('#dlg-' + this.id).dialog('open');
			$('#fm-' + this.id).form('load',row);
			if(this.fckeditors) {
				var fckeditors = this.fckeditors.split(',');
				for(var i = 0; i < fckeditors.length; i++) {
					var field = fckeditors[i];
					FCKeditorAPI.Instances[field].SetData(row[field]);
				}
				
			}
			if(this.multiselects) {
				var multiselects = this.multiselects.split(',');
				for(var i = 0; i < multiselects.length; i++) {
					var field = multiselects[i];
					var selecteds = row[field].split(',');
					$('#' + field).find('option').attr('selected', false);
					for(var i = 0; i < selecteds.length; i++) {
						if(selecteds[i])
							$('#' + field).find('option[value='+selecteds[i]+']').attr('selected', true);
					}
				}
				
			}
			this.url = BASE_URL + '/index.php'+this.controller+'/edit?table=' + this.table;
		}
	},
	/**
	 * Xóa các bản ghi đang chọn
	 */
	del: function(success) {
		var that = this;
		if(that.singleSelect == 'false' || that.singleSelect == false) {
			var rows = $('#' + this.id).datagrid('getSelections');
			if(rows.length > 0) {
				$.messager.confirm('Confirm','Có chắc sẽ xóa bản ghi này?',function(r){
					if (r){
						var ids = [];
						for(var i = 0; i < rows.length; i++) {
							ids.push(rows[i]['id']);
						}
						$.post(BASE_URL + '/index.php'+that.controller+'/del?table=' + that.table,{ids:ids},function(result){
							if (result.success){
								if(typeof success !== 'undefined') {
									success(result);
								}
								$('#' + that.id).datagrid('reload');    // reload the user data
								$.messager.show({    // show error message
									title: 'Success',
									msg: 'Các bản ghi đã được xóa thành công'
								});
							} else {
								$.messager.show({    // show error message
									title: 'Error',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
			
			return true;
		}
		var row = $('#' + this.id).datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Có chắc sẽ xóa bản ghi này?',function(r){
				if (r){
					$.post(BASE_URL + '/index.php'+that.controller+'/del?table=' + that.table,{id:row.id},function(result){
						if (result.success){
							if(typeof success !== 'undefined') {
								success(result);
							}
							$('#' + that.id).datagrid('reload');    // reload the user data
						} else {
							$.messager.show({    // show error message
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		}
	},
	/**
	 * Lưu dữ liệu trên form thêm hoặc form sửa
	 */
	save: function(formId) {
		var that = this;
		var dialogMode = true;
		if(typeof formId != 'undefined') {
			dialogMode = false;
		}
		formId = formId || '#fm-' + this.id;
		wasSubmitted = false;
		if(!wasSubmitted) {
			wasSubmitted = true;
			$(formId).form('submit',{
				url: that.url,
				onSubmit: function(params){
					if(that.defaultFilters) {
						var filters = JSON.parse(that.defaultFilters);
						for(var k in filters) {
							var fieldValue = $(formId).find('[name=' + k + ']').val();
							if (null === fieldValue || '' === fieldValue) {
								params[k] = filters[k];
							}
						}
					}
					return $(this).form('validate');
				},
				success: function(result){
					result = result.replace('\=""', '\\\/');
					wasSubmitted = false;
					var result = eval('('+result+')');
					if (result.errorMsg){
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					} else {
						if(that.saveMode == 'add') {
							if(typeof that.onAdd !== 'undefined') {
								if(typeof window[that.onAdd] !== 'undefined') {
									window[that.onAdd](result.data);
								}
							}
						}
						if(that.saveMode == 'edit') {
							if(typeof that.onEdit !== 'undefined') {
								if(typeof window[that.onEdit] !== 'undefined') {
									window[that.onEdit](result.data);
								}
							}
						}
						if(dialogMode)
							$('#dlg-' + that.id).dialog('close');        // close the dialog
						$('#' + that.id).datagrid('reload');    // reload the user data
					}
					return false;
				}
			});
		}
	},
	/**
	 * Tải lại dữ liệu trên datagrid
	 */
	reload: function() {
		$('#' + this.id).datagrid('reload');
	},
	addToTable: function(options) {
		var row = $('#' + this.id).datagrid('getSelected');
		var data = {};
		if (row){
			data[options.gridField] = row.id;
			data[options.tableField] = $(options.tableFieldSource).val();
			if(!!options.tableField2)
				data[options.tableField2] = $(options.tableFieldSource2).val();
			if(!!options.tableField3)
				data[options.tableField3] = $(options.tableFieldSource3).val();
			if(!!options.tableField4)
				data[options.tableField4] = $(options.tableFieldSource4).val();
			if(!!options.tableField5)
				data[options.tableField5] = $(options.tableFieldSource5).val();
			if(!!data[options.tableField]) {
				$.post(options.url,data,function(result){
					if (!result.errorMsg){
						$.messager.show({    // show error message
							title: 'Success',
							msg: 'Cập nhật thành công'
						});
					} else {
						$.messager.show({    // show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		}
	},
	defaultBuilder: function(row, options) {
		
		var data = {};
		
		if(typeof options['gridField'] != 'undefined') {
			data[options.gridField] = row.id;
		}
		
		if(typeof options['fields'] != 'undefined') {
			var fields = options.fields;
			for(var field in fields) {
				var fieldOptions = fields[field];
				if(typeof fieldOptions == 'string') {
					data[field] = $(fieldOptions).pzkVal();
				} else if(typeof fieldOptions == 'object') {
					if(fieldOptions.source && fieldOptions.source == 'grid') {
						data[field] = row[fieldOptions.field];
					}
				}
			}
		}
		
		return data;
	},
	
	actOnSelected: function(options) {
		var row = $('#' + this.id).datagrid('getSelected');
		var data = {};
		if (row){
			var builder = options.builder || this.defaultBuilder;
			data = builder.call(this, row, options);
			$.post(options.url,data,function(result){
				if (!result.errorMsg){
					$.messager.show({    // show error message
						title: 'Success',
						msg: 'Cập nhật thành công'
					});
				} else {
					$.messager.show({    // show error message
						title: 'Error',
						msg: result.errorMsg
					});
				}
			},'json');
		}
	},
	actOnSelections: function(options) {
		var rows = $('#' + this.id).datagrid('getSelections');
		for(var i = 0; i < rows.length; i++) {
			var row = rows[i];
			var data = {};
			if (row) {
				var builder = options.builder || this.defaultBuilder;
				data = builder.call(this, row, options);
				$.post(options.url, data, function (result) {
					if (!result.errorMsg) {
						$.messager.show({    // show error message
							title: 'Success',
							msg: 'Cập nhật thành công'
						});
					} else {
						$.messager.show({    // show error message
							title: 'Error',
							msg: result.errorMsg
						});
					}
				}, 'json');
			}	
		}
	},
	search: function(options) {
		var builder = options.builder || this.defaultBuilder;
		var data = builder.call(this, null, options);
		if(data)
			$('#' + this.id).datagrid('load', {filters: data});
	},
	export: function(options, type, callback) {
		var that = this;
		var builder = options.builder || this.defaultBuilder;
		var data = builder.call(this, null, options);
		if(that.defaultFilters) {
			var filters = JSON.parse(that.defaultFilters);
			for(var k in filters) {
				data[k] = filters[k];
			}
		}
		$.ajax({
			url: BASE_URL + '/index.php/dtable/json?table=' + this.table,
			type: 'post',
			dataType: 'json',
			data: jQuery.extend({
				filters: data,
				export: type,
				rows: options.rows || 2000000000,
				page: options.page || 1,
			}, options),
			success: function(resp) {
				var ext = 'json';
				if(type === 'csv') {
					ext = 'csv';
				} else if(type === 'excel' || type === 'xlsx') {
					ext = 'xlsx';
				} else if(type === 'html') {
					ext = 'html';
				}
				var path= resp.file; 
    var save = document.createElement('a');  
    save.href = path; 
    save.download = that.table + '.' + ext; 
    save.target = '_blank'; 
    document.body.appendChild(save);
    save.click();
				document.body.removeChild(save);
				if(callback) {
					callback(resp);
				}
			}
		});
	},
	getRows: function(options, callback) {
		var that = this;
		var builder = options.builder || this.defaultBuilder;
		var data = builder.call(this, null, options);
		if(that.defaultFilters) {
			var filters = JSON.parse(that.defaultFilters);
			for(var k in filters) {
				data[k] = filters[k];
			}
		}
		$.ajax({
			url: BASE_URL + '/index.php/dtable/json?table=' + this.table,
			type: 'post',
			dataType: 'json',
			data: {
				filters: data,
				rows: options.rows || 1,
				page: options.page || 1
			},
			success: function(resp) {
				console.log(resp);
				if(callback)
					callback(resp);
			}
		});
	},
	filters: function(data) {
		if(data)
			$('#' + this.id).datagrid('load', {filters: data});
	},
	detail: function(options) {
		var row = $('#' + this.id).datagrid('getSelected');
		var data = {};
		if (row){
			if(typeof options == 'function') {
				options(row);
				return true;
			}
			var builder = options.builder || this.defaultBuilder;
			data = builder.call(this, row, options);
			if(options.action && options.action == 'view') {
				window.open(options.url + '?' + $.param(data));
				return ;
			}
			if(options.action && options.action == 'render') {
				$.post(options.url,data,function(result){
					$(options.renderRegion).empty();
					$(options.renderRegion).html(result);
				});
			}
		}
	},
	getSelected: function(field) {
		var row = $('#' + this.id).datagrid('getSelected');
		if(row) {
			if(typeof field !== 'undefined') {
				return row[field] || null;
			} else {
				return row;
			}
		}
		return null;
	},
	datagrid: function(options) {
		return $('#' + this.id).datagrid(options);
	},
	getDatagrid: function() {
		return $('#' + this.id);
	},
	doExport: function() {
		// open export dialog
		$('#export_' + this.id).dialog('open');
		pzk.elements['export_' + this.id].startOver();
	},
	doImport: function() {
		// open export dialog
		$('#import_' + this.id).dialog('open');
		pzk.elements['import_' + this.id].startOver();
	},
	toggleSingleSelect: function() {
		var that = this;
		if(that.singleSelect === 'true' || that.singleSelect === true) {
			that.singleSelect = 'false';
			that.datagrid({'singleSelect': false});
		} else {
			that.singleSelect = 'true';
			that.datagrid({'singleSelect': true});
		}
	}
});
PzkEasyuiTreeTreeGrid = PzkObj.pzkExt({
	init: function() {
	},
	add: function() {
		$('#dlg-' + this.id).dialog('open');
		$('#fm-' + this.id).form('clear');
		this.url = BASE_URL + '/index.php/Dtable/add?table=' + this.table;
	},
	edit: function() {
		var row = $('#' + this.id).datagrid('getSelected');
		if (row){
			$('#dlg-' + this.id).dialog('open');
			$('#fm-' + this.id).form('load',row);
			this.url = BASE_URL + '/index.php/Dtable/edit?table=' + this.table;
		}
	},
	del: function() {
		var that = this;
		if(that.singleSelect == 'false' || that.singleSelect == false) {
			var rows = $('#' + this.id).datagrid('getSelections');
			if(rows.length > 0) {
				$.messager.confirm('Confirm','Có ch?c s? xóa b?n ghi này?',function(r){
					if (r){
						var ids = [];
						for(var i = 0; i < rows.length; i++) {
							ids.push(rows[i]['id']);
						}
						$.post(BASE_URL + '/index.php/Dtable/del?table=' + that.table,{ids:ids},function(result){
							if (result.success){
								$('#' + that.id).datagrid('reload');    // reload the user data
								$.messager.show({    // show error message
									title: 'Success',
									msg: 'Các b?n ghi ð? ðý?c xóa thành công'
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
			$.messager.confirm('Confirm','Có ch?c s? xóa b?n ghi này?',function(r){
				if (r){
					$.post(BASE_URL + '/index.php/Dtable/del?table=' + that.table,{id:row.id},function(result){
						if (result.success){
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
	save: function() {
		var that = this;
		$('#fm-' + this.id).form('submit',{
			url: that.url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.errorMsg){
					$.messager.show({
						title: 'Error',
						msg: result.errorMsg
					});
				} else {
					$('#dlg-' + that.id).dialog('close');        // close the dialog
					$('#' + that.id).treegrid('reload');    // reload the user data
				}
			}
		});
	},
	addToTable: function(options) {
		var row = $('#' + this.id).datagrid('getSelected');
		var data = {};
		if (row){
			data[options.gridField] = row.id;
			data[options.tableField] = $(options.tableFieldSource).val();
			if(!!data[options.tableField]) {
				$.post(options.url,data,function(result){
					if (!result.errorMsg){
						$.messager.show({    // show error message
							title: 'Success',
							msg: 'C?p nh?t thành công'
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
					data[field] = $(fieldOptions).val();
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
						msg: 'C?p nh?t thành công'
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
	search: function(options) {
		var builder = options.builder || this.defaultBuilder;
		var data = builder.call(this, null, options);
		$('#' + this.id).datagrid('load', {filters: data});
	},
	detail: function(options) {
		var row = $('#' + this.id).datagrid('getSelected');
		var data = {};
		if (row){
			var builder = options.builder || this.defaultBuilder;
			data = builder.call(this, row, options);
			$.post(options.url,data,function(result){
				if (!result.errorMsg){
					$.messager.show({    // show error message
						title: 'Success',
						msg: 'C?p nh?t thành công'
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
});
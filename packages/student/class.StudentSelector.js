// Js
PzkEduStudentSelector = PzkObj.pzkExt({
	showStudentSelectorDialog: function(initialFilters) {
		
		$('#dlg_student_'+this.id).dialog('open');
		if(initialFilters) {
			if(!this.initialFilters) {
				this.initialFilters = initialFilters;
				for(var k in initialFilters) {
					var v = initialFilters[k];
					$('#dg_search_' + this.id + ' [name='+k+']').val(v);
				}
				this.searchStudent();
			}
		}
	},
	closeStudentSelectorDialog: function() {
		$('#dlg_student_'+this.id).dialog('close');
	},
	showDialog: function(initialFilters) {
		return this.showStudentSelectorDialog(initialFilters);
	},
	hideDialog: function () {
		return this.closeStudentSelectorDialog();
	},
	getDialog: function() {
		return $('#dlg_student_'+this.id);
	},
	dialog: function(options) {
		return $('#dlg_student_'+this.id).dialog(options);
	},
	getDatagridObj: function() {
		return pzk.elements['dg_student_'+this.id];
	},
	resetStudentSelector: function() {
		$('#'+this.id).val('');
		$('#label-'+this.id).text('(Trống)');
		$('#'+this.id).change();
	},
	setStudentSelected: function(row) {
		if(row) {
			$('#'+this.id).val(row.id);
			$('#label-'+this.id).text(row.name);
			$('#'+this.id).change();
		} else {
			this.resetStudentSelector();
		}
	},
	getValue: function() {
		return $('#'+this.id).val();
	},
	loadValue: function() {
		var value = $('#'+this.id).val();
		this.setValue(value);
	},
	resetValue: function() {
		this.setValue(null);
	},
	setValue: function(id) {
		if(!id) {
			this.resetStudentSelector();
			return false;
		}
		var that = this;
		$.ajax({
			url: BASE_URL + '/index.php/dtable/get',
			dataType: 'json',
			type: 'post',
			data: {
				id: id,
				fields: 'id,name',
				table: 'student'
			},
			success: function(row) {
				that.setStudentSelected(row);
			}
		});
	},
	searchStudent: function() {
		pzk.elements['dg_student_'+this.id].search({
			'fields': {
				'name' : '#searchName_'+this.id, 'classIds' : '#searchClassIds_'+this.id, 
				'phone': '#searchPhone_'+this.id, 'periodId' : '#searchPeriod_'+this.id, 
				'notlikeperiodId': '#searchnotlikePeriod_'+this.id,
				'subjectIds': '#searchSubject_'+this.id,
				'color': '#searchColor_'+this.id,
				'fontStyle': '#searchFontStyle_'+this.id,
				'assignId': '#searchAssignId_'+this.id,
				'online': '#searchOnline_'+this.id,
				'type': '#searchType_'+this.id,
				'classed': '#searchClassed_'+this.id,
				'status': '#searchStatus_'+this.id,
				'rating': '#searchRating_'+this.id
			}
		});
	}
});

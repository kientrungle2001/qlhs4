// Js
PzkEduCourseSelector = PzkObj.pzkExt({
	showCourseSelectorDialog: function(initialFilters) {
		$('#dlg_course_'+this.id).dialog('open');
		if(initialFilters) {
			if(!this.initialFilters) {
				this.initialFilters = initialFilters;
				for(var k in initialFilters) {
					var v = initialFilters[k];
					$('#dg_course_' + this.id + '_search [name='+k+']').val(v);
				}
				this.searchCourse();
			}
		}
	},
	closeCourseSelectorDialog: function() {
		$('#dlg_course_'+this.id).dialog('close');
	},
	resetCourseSelector: function() {
		$('#'+this.id).val('');
		$('#label-'+this.id).text('(Trống)');
		$('#'+this.id).change();
	},
	setCourseSelected: function(row) {
		if(row) {
			$('#'+this.id).val(row.id);
			$('#label-'+this.id).text(row.name);
			$('#'+this.id).change();
		} else {
			this.resetCourseSelector();
		}
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
			this.resetCourseSelector();
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
				table: 'classes'
			},
			success: function(row) {
				that.setCourseSelected(row);
			}
		});
	},
	searchCourse: function() {
		pzk.elements['dg_course_'+this.id].search({
			'fields': {
				'teacherId' : '#searchTeacher_'+this.id, 
				'subjectId': '#searchSubject_'+this.id, 
				'level': '#searchLevel_'+this.id,
				'status': '#searchStatus_'+ this.id,
				'online': '#searchOnline_'+ this.id
			}
		});
	}
});

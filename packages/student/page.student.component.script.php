<script type="text/javascript">
		/**
		* Hàm tìm kiếm học sinh hiển thị ra danh sách học sinh
		 */
		function searchStudent() {
			pzk.elements.dg.search({
				'fields': {
					'keyword' : '#searchKeyword', 
					'classIds' : '#searchClassIds', 
					'periodId' : '#searchPeriod', 
					'notlikeperiodId': '#searchnotlikePeriod',
					'subjectIds': '#searchSubject',
					'color': '#searchColor',
					'fontStyle': '#searchFontStyle',
					'assignId': '#searchAssignId',
					'online': '#searchOnline',
					'type': '#searchType',
					'classed': '#searchClassed',
					'status': '#searchStatus',
					'rating': '#searchRating' 
				}
			});
		}

		function exportStudent(type) {
			pzk.elements.dg.export({
				'fields': {
					'classIds' : '#searchClassIds', 
					'periodId' : '#searchPeriod', 
					'notlikeperiodId': '#searchnotlikePeriod',
					'subjectIds': '#searchSubject',
					'color': '#searchColor',
					'fontStyle': '#searchFontStyle',
					'assignId': '#searchAssignId',
					'online': '#searchOnline',
					'type': '#searchType',
					'classed': '#searchClassed',
					'status': '#searchStatus',
					'rating': '#searchRating' 
				}
			}, type);
		}

		function exportAllStudent(type) {
			pzk.elements.dg.export({
				'fields': {
				}
			}, type);
		}

		function exportCurrentPageStudent(type) {
			pzk.elements.dg.export({
				'fields': {
					'classIds' : '#searchClassIds', 
					'periodId' : '#searchPeriod', 
					'notlikeperiodId': '#searchnotlikePeriod',
					'subjectIds': '#searchSubject',
					'color': '#searchColor',
					'fontStyle': '#searchFontStyle',
					'assignId': '#searchAssignId',
					'online': '#searchOnline',
					'type': '#searchType',
					'classed': '#searchClassed',
					'status': '#searchStatus',
					'rating': '#searchRating' 
				},
				page: pzk.elements.dg.datagrid('options').pageNumber,
				rows: pzk.elements.dg.datagrid('options').pageSize
			}, type);
		}

		function getStudentSearchOption() {
			return {
				'fields': {
					'classIds' : '#searchClassIds', 
					'periodId' : '#searchPeriod', 
					'notlikeperiodId': '#searchnotlikePeriod',
					'subjectIds': '#searchSubject',
					'color': '#searchColor',
					'fontStyle': '#searchFontStyle',
					'assignId': '#searchAssignId',
					'online': '#searchOnline',
					'type': '#searchType',
					'classed': '#searchClassed',
					'status': '#searchStatus',
					'rating': '#searchRating' 
				}
			};
		}

		/**
		* Hiển thị các lớp đang học khi chọn vào 1 học sinh
		 */
		function selectClass(student) {
			var currentClassNames = student.currentClassNames;
			jQuery('#cmbClass3 option').each(function(index, elem){
				if(currentClassNames.indexOf(jQuery(elem).text().trim()) != -1) {
					jQuery(elem).show();
				} else {
					jQuery(elem).hide();
				}
			});
			jQuery('#cmbClass4 option').each(function(index, elem){
				if(currentClassNames.indexOf(jQuery(elem).text().trim()) != -1) {
					jQuery(elem).show();
				} else {
					jQuery(elem).hide();
				}
			});
			
		}
		
	</script>
	<script type="text/javascript">
	<![CDATA[
	function searchClasses() {
		pzk.elements.dg_classes.search({
			'fields': {
				'teacherId' : '#searchTeacher', 
				'subjectId': '#searchSubject2', 
				'level': '#searchLevel',
				'status': '#searchStatus'
			}
		});
	}

	function studentRowStyler(index, row) {
		var style = '';
		if(row.color !== '') {
			style += 'color:' + row.color + ';';
		}
		
		if(row.fontStyle !== '') {
			if(row.fontStyle === 'bold')
				style += 'font-weight: bold;';
			else if(row.fontStyle === 'italic') {
				style += 'font-style: italic;';
			} else if(row.fontStyle === 'underline') {
				style += 'text-decoration: underline;';
			}
		}
		if(style === '') {
			var studentDate = new Date(row.startStudyDate);
			var currentDate = new Date();
			return (currentDate.getTime() - studentDate.getTime() > 365 * 24 * 3600 * 1000) ?  'color: grey;': '';
		} else {
			return style;
		}
	}
	function studentNameFormatter(value, row, index) {
		return '<strong>' + row.name + '</strong>' + (row.code !== '' ? '<br />' + row.code: '') + (row.phone !== '' ? '<br />' + row.phone: '') + (row.startStudyDate !== '' ? '<br />' + row.startStudyDate: '');
	}

	function importStudent(type) {
		var $fileUpload = jQuery('#fileUpload');
		if(!$fileUpload.length) {
			$fileUpload = jQuery('<input type="file" id="fileUpload" accept=".csv,.json" />');
			jQuery('body').append($fileUpload);
			$fileUpload.change(function(evt){
				var file    = evt.target.files[0];
				var reader  = new FileReader();

				reader.addEventListener("load", function () {
					var students = [];
					var str = reader.result;
					var lines = str.split(/\r\n|\r|\n/g);
					lines.forEach(function(line, index) {
						if(index > 50) return false;
						try {
							var student = JSON.parse(line);
							students.push(student);
							viewImportStudent(students);
						} catch(err) {
							console.log(err);
						}
					});
				}, false);

				if (file) {
						reader.readAsText(file);
				}
			});
		}
		$fileUpload.click();
	}
	function viewImportStudent(students) {
		jQuery('#import_area').css('overflow', 'scroll');
		jQuery('#import_area').html('');
		var tableHtml = '<table style="width: 100%;border-collapse:collapse;" border="1">';
		if(students) {
			var firstStudent = students[0];
			tableHtml += '<tr>';
				for(var field in firstStudent) {
					tableHtml += '<th style="white-space: nowrap;">' + field + '</th>';
				}
			tableHtml += '</tr>';
		}
		students.forEach(function(student, index){
			if(index > 50) return false;
			tableHtml += '<tr>';
				for(var field in student) {
					var value = student[field];
					tableHtml += '<td style="white-space: nowrap;">' + value + '</td>';
				}
			tableHtml += '</tr>';
		});
		tableHtml += '</table>';
		jQuery('#import_area').html(tableHtml);
		jQuery('#dlg_import_student').dialog('open');
	}
	function exportStudents() {
		var type = $('#exportType').val();
		var range = $('#exportRange').val();
		var exportFunc = exportStudent;
		if(range == 'all') {
			exportFunc = exportAllStudent;
		} else if(range == 'page') {
			exportFunc = exportCurrentPageStudent;
		} else {

		}
		exportFunc(type);
	}
	]]>
</script>
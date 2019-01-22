<script type="text/javascript">
	function searchClasses() {
		pzk.elements.dg.search({
			'fields': {
				'teacherId' : '#searchTeacher', 
				'subjectId': '#searchSubject', 
				'level': '#searchLevel',
				'status': '#searchStatus'
			}
		});
	}
	function searchTeacher() {
		pzk.elements.dgteacher.search({
			'fields': {
				'subjectId': '#searchTeacherSubject', 
				'level': '#searchTeacherLevel'
			}
		});
	}
	function searchStudentOrder() {
		pzk.elements.dg_student_order.filters({
			classId: pzk.elements.dg.getSelected('id'),
			periodId: $('#searchStudentOrderPeriod').val()
		});
	}
	function searchTestStudentMark() {
		pzk.elements.dg_test_student_mark.filters({
			classId: pzk.elements.dg.getSelected('id'),
			testId: $('#searchTestStudentMarkTestId').val()
		});
	}
	function showCalendar() {
		var month = $('#monthSelector').val();
		var classId = pzk.elements.dg.getSelected('id');
		if(!month) {
			alert('Nhập tháng');
			return false;
		}
		if(!classId) {
			alert('Chọn lớp để xem');
			return false;
		}
		$.ajax({
			url: BASE_URL + '/index.php/schedule/class',
			type: 'post',
			data: {
				month: month,
				classId: classId
			},
			success: function(resp) {
				$('#calendarResult').html(resp);
			}
		});
	}
</script>
<script type="text/javascript">
	$('#search_form').submit(function() {
		return false;
	});
	
	pzk_student = {
		data: {
			payment: {
			'0': true,
			'1': true
			},
			payment_period: false
		},
		studentId: 0,
		search: function(key, val) {
			if(key) {
				this.data[key] = val;
			}
			$.ajax({
				url: BASE_URL + '/index.php/student/searchresult',
				type: 'post',
				data: this.data,
				success: function(resp) {
					$('#student_list').html(resp);
				}
			});
		},
		detail: function(id) {
			if (id == this.studentId) {
				return true;
			}
			this.studentId = id;
			$.ajax({
				url: BASE_URL + '/index.php/student/detail',
				type: 'post',
				data: {id: id},
				success: function(resp) {
					$('#student_detail').empty();
					$('#student_detail').html(resp);
				}
			});
			$('#ul_student_list li').removeClass('student_active');
			$('#ul_student_list .student-' + id).addClass('student_active');
		},
		print: function(id) {
		},
		paymentstate: function (state, enabled) {
			if(enabled) {
				this.data.payment[state] = enabled;
			} else {
				delete this.data.payment[state];
			}
			this.search();
		},
		periodselect: function(val) {
			this.data.payment_period = val;
			this.search();
		}
	}
	$('input[name=name]').change(function(evt) {
		var val = $(evt.target).val();
		pzk_student.search('name', val);
	});
	$('input[name=phone]').change(function(evt) {
		var val = $(evt.target).val();
		pzk_student.search('phone', val);
	});
	$('select[name=classId]').change(function(evt) {
		var val = $(evt.target).val();
		pzk_student.search('classId', val);
	});
</script>
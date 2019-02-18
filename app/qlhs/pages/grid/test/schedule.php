<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div style="margin-top: 15px;">
	<!-- Bắt đầu form thêm lịch hẹn -->
	<div style="float: left; width: 300px;">
		<easyui.layout.panel title="Thêm lịch hẹn" collapsible="true">
			<frm.form id="add_test_schedule">
				<frm.formItem name="title" required="true" validatebox="true" label="Tiêu đề" />
				<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
				<frm.formItem name="name" required="false" validatebox="true" label="Tên học sinh" />
				<frm.formItem name="phone" required="false" validatebox="false" label="Số điện thoại" />
				<frm.formItem name="email" required="false" validatebox="false" label="Email" />
				<frm.formItem name="parentName" required="false" validatebox="false" label="Phụ huynh" />
				<frm.formItem type="date" name="testDate" required="false" label="Ngày Thi" />
				<frm.formItem type="time" name="testTime" required="false" label="Thời gian" />
				<frm.formItem type="user-defined" name="classId" required="false" label="Lớp">
					<edu.courseSelector id="courseSelector_add" name="classId" defaultFilters='{"online": 0, "status": 1, "classed": -1}' />
				</frm.formItem>
				<frm.formItem type="user-defined" name="adviceId" required="false" label="Tư vấn viên">
					<form.combobox name="adviceId"
							sql="{teacher_sql}"
								layout="category-select-list"></form.combobox>
				</frm.formItem>
				<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
					<select name="status" class="easyui-combobox">
						<option value="0">Chưa thi</option>
						<option value="1">Đã thi</option>
						<option value="2">Đã có kết quả</option>
						<option value="3">Đã xếp lớp</option>
					</select>
				</frm.formItem>
				<frm.formItem type="user-defined" name="send" required="false" label="">
					<a href="#" class="easyui-linkbutton" onClick="addTestSchedule(); return false;" data-options="iconCls:'icon-plus'">
						Thêm lịch hẹn
					</a>
				</frm.formItem>
			</frm.form>
		</easyui.layout.panel>
	</div>
	<!-- Kết thúc form thêm lịch hẹn -->

	<!-- Bắt đầu danh sách lịch hẹn -->
	<div style="float: left; width: 550px; margin-left: 15px;">
		<dg.dataGrid id="dg" title="Lịch hẹn thi đầu vào" scriptable="true" 
				table="test_schedule" width="550px" height="450px" nowrap="false"
				rowStyler="adviceRowStyler"
				onClickRow="testScheduleClickRow"
				noClickRow="true" defaultFilters='{"`ts`.`type`": 0}'>
			<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
			
			<!--<dg.dataGridItem field="title" width="320">Tiêu đề</dg.dataGridItem>-->
			<dg.dataGridItem field="studentName" width="320" formatter="scheduleStudentFormat">Học sinh</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="phone" width="220">Điện thoại</dg.dataGridItem>
			-->
			<!--<dg.dataGridItem field="subjectName" width="220">Môn</dg.dataGridItem>-->
			<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
			
			<dg.dataGridItem field="adviceName" width="120">Tư vấn viên</dg.dataGridItem>
			<dg.dataGridItem field="testDate" width="120" formatter="scheduleDateTimeFormat">Ngày Thi</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="testTime" width="120">Thời gian</dg.dataGridItem>
			-->
			<dg.dataGridItem field="status" width="120" formatter="adviceStatusFormatter">Trạng thái</dg.dataGridItem>
			<layout.toolbar id="dg_toolbar">
				<hform id="dg_search">
					<edu.courseSelector name="classId" id="searchClass" defaultFilters='{"online": 0, "classed":-1, "status": 1}' onChange="pzk.elements.dg.search({'fields': {'classId' : '#searchClass', 'studentId': '#searchStudent' }})" />
					<edu.studentSelector name="studentId" id="searchStudent" defaultFilters='{"classed":-1, "online": 0}' onChange="pzk.elements.dg.search({'fields': {'classId' : '#searchClass', 'studentId': '#searchStudent' }})" />
					<layout.toolbarItem action="$dg.search({'fields': {'classId' : '#searchClass', 'studentId': '#searchStudent' }})" icon="search" />
					<layout.toolbarItem action="$dg.add(); $studentSelector.resetValue();$courseSelector.resetValue();" icon="add" />
					<layout.toolbarItem action="$dg.edit(); $studentSelector.loadValue();$courseSelector.loadValue();" icon="edit" />
					<layout.toolbarItem action="$dg.del()" icon="remove" />
				</hform>
			</layout.toolbar>
			<wdw.dialog gridId="dg" width="700px" height="auto" title="Phần mềm">
				<frm.form gridId="dg">
					<frm.formItem type="hidden" name="id" required="false" label="" />
					<frm.formItem type="user-defined" name="type" required="false" label="Loại hình">
						<select name="type" class="easyui-combobox">
							<option value="0">Cuộc gọi</option>
							<option value="1">Tin nhắn</option>
							<option value="2">Facebook</option>
							<option value="3">Email</option>
							<option value="4">Gặp gỡ</option>
						</select>
					</frm.formItem>
					<frm.formItem name="title" required="true" validatebox="true" label="Tiêu đề" />
					<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
					<frm.formItem 
						type="user-defined"
						name="studentId" required="false" validatebox="false" label="Học sinh">
					<edu.studentSelector name="studentId" id="studentSelector" defaultFilters='{"online": 0, "status": 1, "classed": -1}' />
				</frm.formItem>
					<frm.formItem type="date" name="testDate" required="false" label="Ngày Thi" />
					<frm.formItem type="time" name="testTime" required="false" label="Thời gian" />
					<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
						<form.combobox name="subjectId"
								sql="{subject_center_sql}"
									layout="category-select-list"></form.combobox>
					</frm.formItem>
					<frm.formItem type="user-defined" name="classId" required="false" label="Khóa học">
						<edu.courseSelector id="courseSelector" name="classId" defaultFilters='{"online": 0, "status": 1, "classed": -1}' />
					</frm.formItem>
					<frm.formItem type="user-defined" name="adviceId" required="false" label="Giáo viên">
						<form.combobox name="adviceId"
								sql="{teacher_sql}"
									layout="category-select-list"></form.combobox>
					</frm.formItem>
					<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
						<select name="status" class="easyui-combobox">
						<option value="-1">Hủy lịch hẹn</option>
							<option value="0">Chưa thi</option>
							<option value="1">Đã thi</option>
							<option value="2">Đã có kết quả</option>
							<option value="3">Đã xếp lớp</option>
						</select>
					</frm.formItem>
				</frm.form>
			</wdw.dialog>
		</dg.dataGrid>
	</div>
	<!-- Kết thúc form danh sách lịch hẹn -->

	<!-- Bắt đầu form nghiệp vụ -->
	<div style="float: left; width: 400px; margin-left: 15px;">
		<easyui.layout.panel title="Lịch hẹn" collapsible="true">
		<div style="padding: 15px;">
			<h3>Xếp lớp cho học sinh: <span id="studentName"></span></h3>

			Chọn lớp: <edu.courseSelector id="classSelector" defaultFilters='{"classed": 1, "online": 0, "status": 1}' /> <br /><br />
			Ngày vào học: <input type="date" id="startDate" /><br /><br />
			<a href="#" class="easyui-linkbutton" onClick="scheduleClassStudent(); return false;">Xếp vào lớp</a>
			<a href="#" class="easyui-linkbutton" onClick="cancelTestSchedule(); return false;">Hủy lịch hẹn</a>
			<a href="#" class="easyui-linkbutton" onClick="deleteStudent(); return false;">Xóa học sinh</a>
		</div>
		</easyui.layout.panel>
		<br />
		<easyui.layout.panel title="Lịch hẹn" collapsible="true">
			<div id="chitiet" style="padding: 15px;">
				<h3>Chi tiết lịch hẹn</h3>
				Tên học sinh: <span id="detail_studentName" class="pzk-field-studentName" /><br />
				Số điện thoại: <span id="detail_phone" class="pzk-field-phone" /><br />
				Email: <span id="detail_email" class="pzk-field-email" /><br />
				Tên phụ huynh: <span id="detail_parentName" class="pzk-field-parentName" /><br />
				Lớp đăng ký: <span id="detail_className" class="pzk-field-className" /><br />
				Thời gian thi: <span id="detail_testTime" class="pzk-field-testTime" /> ngày <span id="detail_testDate" class="pzk-field-testDate" /><br />
				Người tư vấn: <span id="detail_adviceName" class="pzk-field-adviceName" /><br />
				Trạng thái: <span id="detail_status" /><br />
				---------------<br />
				Tiêu đề: <span id="detail_title" /><br />
				Ghi chú: <span id="detail_note" /><br />
				---------------<br />
				Lịch sử tư vấn: <br />
			</div>
		</easyui.layout.panel>
	</div>
	<!-- Kết thúc form nghiệp vụ -->

	<script>
	/**
	Format trạng thái lịch hẹn
	 */
	function adviceStatusFormatter(value,row,index) {
		switch(value) {
			case '-1': return 'Hủy lịch hẹn';
			case '0': return 'Chưa thi';
			case '1': return 'Đã thi';
			case '2': return 'Đã có kết quả';
			case '3': return 'Đã xếp lớp';
		}
	}
	
	/**
	Format màu sắc bản ghi
	 */
	function adviceRowStyler(index, row) {
		if(row.status == '-1') {
			return 'color: gray; font-weight: normal;';
		}
		if(row.status == '0') {
			return 'color: red; font-weight: normal;';
		}
		if(row.status == '1') {
			return 'color: blue; font-weight: bold;';
		}
		if(row.status == '2') {
			return 'color: green; font-weight: bold;';
		}
		if(row.status == '3') {
			return 'color: black; font-weight: bold;';
		}
		return '';
	}
	function scheduleDateFormat(value, row, index) {
		var tmp = value.split('-');
		return tmp[2] + '/' + tmp[1];
	}
	function scheduleTimeFormat(value, row, index) {
		var tmp = value.split(':');
		return tmp[0] + ':' + tmp[1];
	}
	function scheduleDateTimeFormat(value, row, index) {
		return scheduleTimeFormat(row.testTime) + ' ' + scheduleDateFormat(row.testDate);
	}
	function scheduleStudentFormat(value, row, index) {
		return row.studentName + ' - ' + row.phone;
	}
	/**
	Xem chi tiết lịch hẹn
	 */
	function testScheduleClickRow(index, row) {
		$('#studentName').html(row.studentName);
		$('#chitiet').pzkTemplate(row);
		$('#detail_status').html(adviceStatusFormatter(row.status));
		/*
		for(var field in row) {
			if(field == 'status') {
				$('#detail_' + field).html(adviceStatusFormatter(row[field]));
			} else {
				$('#detail_' + field).html(row[field]);
			}
			
		}
		*/
		console.log(row);
		pzk.elements.classSelector.filter({
			level: row.level,
			teacherId: row.teacherId,
			subjectId: row.subjectId
		});
	}
	/**
	Sắp lớp cho học sinh theo lịch hẹn
	 */
	function scheduleClassStudent() {
		/*alert('Xếp lớp');*/
		var classId = pzk.elements.classSelector.getValue();
		var startClassDate = jQuery('#startDate').pzkVal();
		var schedule = pzk.elements.dg.getSelected();
		console.log(classId);
		console.log(startClassDate);
		console.log(schedule);
		if(!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		if(schedule.status == '3') {
			$.messager.alert('Lỗi', 'Đã xếp lớp cho học sinh này');
			return false;
		}
		if(!classId) {
			$.messager.alert('Lỗi', 'Chưa chọn lớp');
			return false;
		}
		if(!startClassDate) {
			$.messager.alert('Lỗi', 'Chưa chọn ngày bắt đầu học');
			return false;
		}
		/** 
			* Đánh dấu là đã xếp lớp
			* Xếp lớp
		 */
		pzk.db.update('test_schedule', {
			id: schedule.id,
			status: 3
		}, function(resp){
			console.log(resp);
			if(!resp.errorMsg) {
				pzk.db.add('class_student', {
					studentId: schedule.studentId,
					classId: classId,
					startClassDate: startClassDate
				}, function(resp){
					if(resp.errorMsg) {
						$.messager.show({title: 'Thất bại', msg: resp.errorMsg});
					} else {
						$.messager.show({ title: 'Thành công', msg: 'Đã xếp lớp thành công'});
						pzk.db.update('student', {
							id: schedule.studentId,
							classed: 1
						}, function(resp){
							if(resp.errorMsg) {
								$.messager.show({title: 'Thất bại', msg: resp.errorMsg});
							} else {
									pzk.elements.dg.reload();
							}
						})
						
					}
					
				});
				
			} else {
				$.messager.show({title: 'Thất bại', msg: resp.errorMsg});
			}
		});
	}

	/**
	Hủy lịch hẹn
	 */
	function cancelTestSchedule() {
		var schedule = pzk.elements.dg.getSelected();
		if(!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		$.messager.confirm('Xác nhận', 'Bạn có muốn hủy lịch hẹn này?', function(r) {
			if(r) {
				if(schedule.status == '0') {
					pzk.db.update('test_schedule', {
						id: schedule.id,
						status: -1
					}, function(resp){
						if(resp.errorMsg) {
							$.messager.show({
								title: 'Thất bại',
								msg: resp.errorMsg
							});
						} else {
							pzk.elements.dg.reload();
							$.messager.show({title: 'Thành công', msg: 'Bạn đã hủy lịch hẹn'});
						}
					});
					
				} else {
					$.messager.alert('Thất bại', 'Chỉ học sinh chưa thi mới được quyền hủy lịch hẹn');
				}
			}
		}); 
		
	}
	/**
	Thêm lịch hẹn
	 */
	function addTestSchedule() {
		var data = jQuery('#add_test_schedule').serializeForm();
		data.classed = -1;
		data.status = 0;
		data.online = 0;
		pzk.db.add('student', data, function(resp){
			var data = jQuery('#add_test_schedule').serializeForm();
			if(resp.errorMsg == false) {
				var student = resp.data;
				var id = student.id;
				data.studentId = id;
				pzk.db.add('test_schedule', data, function(resp) {
					if(resp.errorMsg == false) {
						$.messager.show({
							title: 'Success',
							msg: 'Đã thêm thành công'
						});
						pzk.elements.dg.reload();
					} else {
						$.messager.show({
							title: 'Error',
							msg: resp.errorMsg
						});
					}
				});
			} else {
				$.messager.show({
					title: 'Error',
					msg: resp.errorMsg
				});
			}
		});
	}
	function deleteStudent() {
		var schedule = pzk.elements.dg.getSelected();
		if(!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		if(schedule.status == '3') {
			$.messager.alert('Lỗi', 'Đã xếp lớp cho học sinh này. Nếu bạn muốn xóa, hãy vào quản trị học sinh/trung tâm');
			return false;
		}
		$.messager.confirm('Xác nhận', 'Bạn có muốn xóa học sinh này?', function(r) {
			if(r) {
				pzk.db.del('student', {
					id: schedule.studentId
				}, function(resp) {
					if(resp.errorMsg) {
						$.messager.show({
							title: 'Thất bại',
							msg: resp.errorMsg
						});
					} else {
						$.messager.show({
							title: 'Thành công',
							msg: 'Đã xóa học sinh'
						});
						pzk.elements.dg.reload();
					}
				});
			}
		});
	}
	</script>
</div>

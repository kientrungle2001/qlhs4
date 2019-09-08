<?php require BASE_DIR . '/' . pzk_app()->getUri('constants.php')?>
<div style="margin-top: 15px;">
	<!-- Bắt đầu form thêm tư vấn -->
	<div style="float: left; width: 400px;">
		<easyui.window.dialog id="advice_dialog" layout="easyui/window/dialog" title="Thêm báo lỗi" width="700px">
			<frm.form id="add_advice_schedule">
				<frm.formItem id="add_advice_studentId" type="hidden" name="studentId" required="false"
					validatebox="false" />
				<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
				<frm.formItem type="date" name="testDate" required="false" label="Ngày tư vấn"
					value="<?php echo date('Y-m-d')?>" />
				<frm.formItem type="time" name="testTime" required="false" label="Thời gian" />
				<frm.formItem type="user-defined" name="classId" required="false" label="Phần mềm">
					<edu.courseSelector id="advice_courseSelector_add" name="classId"
						defaultFilters='{"online": 1, "status": 1}' />
				</frm.formItem>
				<frm.formItem type="user-defined" name="adviceId" required="false" label="Tư vấn viên">
					<form.combobox name="adviceId" sql="{teacher_sql}" layout="category-select-list"></form.combobox>
				</frm.formItem>
				<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
					<form.combobox name="status" class="easyui-combobox" layout="category-select-list"
						label="Trạng thái">
						<option value="-2">Lỗi không sửa được</option>
						<option value="-1">Lỗi, vấn đề</option>
						<option value="0">Không có lỗi</option>
						<option value="1">Đang sửa</option>
						<option value="2">Đã sửa xong</option>
					</form.combobox>
				</frm.formItem>
				<frm.formItem type="user-defined" name="send" required="false" label="">
					<a href="#" class="easyui-linkbutton" onClick="addAdviceSchedule(); return false;"
						data-options="iconCls:'icon-plus'">
						Thêm báo lỗi
					</a>
				</frm.formItem>
			</frm.form>
		</easyui.window.dialog>
		<easyui.layout.tabs>
			<easyui.layout.tabpanel title="Học sinh trực tuyến">

				<dg.dataGrid id="dg_online_student" title="Học sinh trực tuyến" table="student" width="400px"
					height="450px" nowrap="false" multiple="true" defaultFilters='{"online": 1}'
					rowStyler="student_adviceRowStyler">
					<dg.dataGridItem field="id" width="50">Id</dg.dataGridItem>
					<dg.dataGridItem field="name" width="180" formatter="onlineName">Học sinh</dg.dataGridItem>
					<dg.dataGridItem field="currentClassNames" width="180" formatter="adviceNote">Phần mềm/môn học
					</dg.dataGridItem>
					<layout.toolbar id="dg_online_student_toolbar">
						<hform id="dg_online_student_search">
							<input type="text" id="advice_studentKeywordSearch" name="keyword" placeholder="Tìm kiếm"
								onKeyUp="advice_studentSearch()" />
							<form.selectbox id="advice_studentStatusSearch" name="adviceStatus" label="Trạng thái"
								onChange="advice_studentSearch()">
								<option value="-2">Lỗi không sửa được</option>
						<option value="-1">Lỗi, vấn đề</option>
						<option value="0">Không có lỗi</option>
						<option value="1">Đang sửa</option>
						<option value="2">Đã sửa xong</option>
							</form.selectbox>
							<form.selectbox id="advice_studentAdviceSearch" name="assignId" label="Người tư vấn"
								onChange="advice_studentSearch()" sql="{teacher_sql}" />
							<layout.toolbarItem action="$dg_online_student.del()" icon="remove" />
						</hform>
					</layout.toolbar>
				</dg.dataGrid>
			</easyui.layout.tabpanel>
			<easyui.layout.tabpanel title="Thêm báo lỗi">

				<easyui.layout.panel title="Thêm báo lỗi" collapsible="true">
					<frm.form id="add_test_schedule">
						<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
						<frm.formItem name="name" required="false" validatebox="true" label="Tên học sinh" />
						<frm.formItem name="phone" required="false" validatebox="false" label="Số điện thoại" />
						<frm.formItem name="email" required="false" validatebox="false" label="Email" />
						<frm.formItem type="date" name="testDate" required="false" label="Ngày tư vấn"
							value="<?php echo date('Y-m-d')?>" />
						<frm.formItem type="time" name="testTime" required="false" label="Thời gian" />
						<frm.formItem type="user-defined" name="classId" required="false" label="Phần mềm">
							<edu.courseSelector id="courseSelector_add" name="classId"
								defaultFilters='{"online": 1, "status": 1}' />
						</frm.formItem>
						<frm.formItem type="user-defined" name="adviceId" required="false" label="Tư vấn viên">
							<form.combobox name="adviceId" sql="{teacher_sql}" layout="category-select-list">
							</form.combobox>
						</frm.formItem>
						<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
							<form.combobox name="status" class="easyui-combobox" layout="category-select-list"
								label="Trạng thái">
								<option value="-2">Lỗi không sửa được</option>
						<option value="-1">Lỗi, vấn đề</option>
						<option value="0">Không có lỗi</option>
						<option value="1">Đang sửa</option>
						<option value="2">Đã sửa xong</option>
							</form.combobox>
						</frm.formItem>
						<frm.formItem type="user-defined" name="send" required="false" label="">
							<a href="#" class="easyui-linkbutton" onClick="addTestSchedule(); return false;"
								data-options="iconCls:'icon-plus'">
								Thêm báo lỗi
							</a>
						</frm.formItem>
					</frm.form>
				</easyui.layout.panel>
			</easyui.layout.tabpanel>
		</easyui.layout.tabs>
		<script>
		<![CDATA[
			function advice_studentSearch() {
				pzk.elements.dg_online_student.search({
					fields: {
						adviceStatus: '#advice_studentStatusSearch',
						keyword: '#advice_studentKeywordSearch',
						assignId: '#advice_studentAdviceSearch'
					}
				});
			}
			function onlineName(value, row, index) {
				return row.name + '<br />' + row.code + '<br />' + row.phone + '<br />' + scheduleDateFormat(row
					.startStudyDate);
			}

			function adviceNote(value, row, index) {
				return row.currentClassNames +
					'<br />' +
					row.assignName +
					'<br />' +
					row.adviceNote +
					'<br />' +
					adviceStatusFormatter(row.adviceStatus) +
					'<br /><a href="#" onClick="showAdviceDialog(' + row.id + '); return false;">Tạo báo lỗi</a>' +
					'<br /><a href="#" onClick="clearAdviceStatus(' + row.id + '); return false;">Clear báo lỗi</a>';
			}

			function showAdviceDialog(studentId) {
				$('#add_advice_studentId').val(studentId);
				$('#advice_dialog').dialog('open');
			}

			function addAdviceSchedule() {
				var data = $('#add_advice_schedule').serializeForm();
				data.type = 2;
				pzk.db.add('test_schedule', data, function(resp) {

					pzk.db.update('student', {
						id: data.studentId,
						adviceStatus: data.status,
						adviceNote: data.note
					}, function(resp) {
						pzk.elements.dg.reload();
						pzk.elements.dg_online_student.reload();
						$.messager.show({
							title: 'Thành công',
							msg: 'Đã tạo báo lỗi'
						});
						$('#advice_dialog').dialog('close');
					});
				});
			}

			function clearAdviceStatus(studentId) {
				pzk.db.update('student', {
					id: studentId,
					adviceStatus: 0,
					adviceNote: ''
				}, function(resp) {
					pzk.elements.dg_online_student.reload();
					$.messager.show({
						title: 'Thành công',
						msg: 'Đã clear'
					});
				});
			}

			function adviceSubjectInfo(value, item, index) {
				return [item.subjectName, item.className].join('<br />');
			}

			function adviceStatusInfo(value, item, index) {
				return [item.adviceName, scheduleDateTimeFormat(value, item, index), adviceStatusFormatter(item.status)]
					.join('<br />');
			}

		]]>
		</script>
	</div>
	<!-- Kết thúc form thêm tư vấn -->

	<!-- Bắt đầu danh sách tư vấn -->
	<div style="float: left; width: 450px; margin-left: 15px;">

		<dg.dataGrid id="dg" title="Vụ việc, báo lỗi" scriptable="true" table="test_schedule" width="450px"
			height="450px" nowrap="false" onAdd="test_schedule_onAdd" onEdit="test_schedule_onAdd"
			rowStyler="adviceRowStyler" onClickRow="testScheduleClickRow" noClickRow="true"
			defaultFilters='{"type": 2}'>
			<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>

			<!--<dg.dataGridItem field="title" width="320">Tiêu đề</dg.dataGridItem>-->
			<dg.dataGridItem field="studentName" width="220" formatter="scheduleStudentFormat">Học sinh
			</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="phone" width="220">Điện thoại</dg.dataGridItem>
			-->
			<dg.dataGridItem field="subjectName" width="220" formatter="adviceSubjectInfo">Phần mềm</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="className" width="120">Gói dịch vụ</dg.dataGridItem>
			-->
			<dg.dataGridItem field="adviceName" width="220" formatter="adviceStatusInfo">Tư vấn viên</dg.dataGridItem>
			<!--
			<dg.dataGridItem field="testDate" width="120" formatter="scheduleDateTimeFormat">Ngày Tư vấn</dg.dataGridItem>
			<dg.dataGridItem field="testTime" width="120">Thời gian</dg.dataGridItem>
			<dg.dataGridItem field="status" width="120" formatter="adviceStatusFormatter">Trạng thái</dg.dataGridItem>
			-->
			<layout.toolbar id="dg_toolbar">
				<hform id="dg_search">
					<input type="text" size="17" placeholder="Tìm kiếm" name="keyword" id="searchKeyword"
						onKeyPress="window.searchAdvice()" />
					<form.selectbox id="searchAdvice" sql="{teacher_sql}" label="Tư vấn viên"
						onChange="searchAdvice()" />
					<form.selectbox name="status" id="searchStatus" onChange="searchAdvice()" label="Trạng thái">
					<option value="-2">Lỗi không sửa được</option>
						<option value="-1">Lỗi, vấn đề</option>
						<option value="0">Không có lỗi</option>
						<option value="1">Đang sửa</option>
						<option value="2">Đã sửa xong</option>
					</form.selectbox>
					<edu.courseSelector name="classId" id="searchClass" defaultFilters='{"online": 1, "status": 1}'
						onChange="searchAdvice()" />
					<edu.studentSelector name="studentId" id="searchStudent" defaultFilters='{"online": 1, "type": 0}'
						onChange="searchAdvice()" />

					<layout.toolbarItem action="searchAdvice()" icon="search" />
					<!--
					<layout.toolbarItem action="$dg.add(); $studentSelector.resetValue();$courseSelector.resetValue();"
						icon="add" />
						-->
					<layout.toolbarItem action="$dg.edit(); $studentSelector.loadValue();$courseSelector.loadValue();"
						icon="edit" />
					<layout.toolbarItem action="$dg.del(function() {
						clearAdviceStatus($dg.getSelected('studentId'));
					})" icon="remove" />
				</hform>
			</layout.toolbar>
			<wdw.dialog gridId="dg" width="700px" height="auto" title="Phần mềm">
				<frm.form gridId="dg">
					<frm.formItem type="hidden" name="id" required="false" label="" />
					<frm.formItem name="note" required="false" validatebox="false" label="Ghi chú" />
					<frm.formItem type="user-defined" name="studentId" required="false" validatebox="false"
						label="Học sinh">
						<edu.studentSelector name="studentId" id="studentSelector"
							defaultFilters='{"online": 0, "status": 1, "classed": -1}' />
					</frm.formItem>
					<frm.formItem type="date" name="testDate" required="false" label="Ngày Tư vấn"
						value="<?php echo date('Y-m-d')?>" />
					<frm.formItem type="time" name="testTime" required="false" label="Thời gian" />
					<frm.formItem type="user-defined" name="classId" required="false" label="Khóa học">
						<edu.courseSelector id="courseSelector" name="classId"
							defaultFilters='{"online": 0, "status": 1, "classed": -1}' />
					</frm.formItem>
					<frm.formItem type="user-defined" name="adviceId" required="false" label="Người tư vấn">
						<form.combobox name="adviceId" sql="{teacher_sql}" layout="category-select-list"
							label="Người tư vấn"></form.combobox>
					</frm.formItem>
					<frm.formItem type="user-defined" name="status" required="false" label="Trạng thái">
						<form.combobox name="status" class="easyui-combobox" layout="category-select-list"
							label="Trạng thái">
							<option value="-2">Lỗi không sửa được</option>
						<option value="-1">Lỗi, vấn đề</option>
						<option value="0">Không có lỗi</option>
						<option value="1">Đang sửa</option>
						<option value="2">Đã sửa xong</option>
						</form.combobox>
					</frm.formItem>
				</frm.form>
			</wdw.dialog>
		</dg.dataGrid>
	</div>
	<!-- Kết thúc form danh sách tư vấn -->

	<!-- Bắt đầu form nghiệp vụ -->
	<div style="float: left; width: 400px; margin-left: 15px;">
		<!--
		<easyui.layout.panel title="Nghiệp vụ" collapsible="true">
			<div style="padding: 15px;">
				Ngày bắt đầu: <input type="date" id="startDate" value="<?php echo date('Y-m-d')?>" /><br /><br />
				<a href="#" class="easyui-linkbutton" onClick="scheduleClassStudent(); return false;">Đăng ký</a>
				<a href="#" class="easyui-linkbutton" onClick="cancelTestSchedule(); return false;">Hủy tư vấn</a>
				<a href="#" class="easyui-linkbutton" onClick="deleteStudent(); return false;">Xóa học sinh</a>
			</div>
		</easyui.layout.panel>
		
		<br />
		-->
		<easyui.layout.panel title="Tư vấn" collapsible="true">
			<div id="chitiet" style="padding: 15px;">
				<h3>Chi tiết báo lỗi</h3>
				Tên học sinh: <span id="detail_studentName" class="pzk-field-studentName" /><br />
				Số điện thoại: <span id="detail_phone" class="pzk-field-phone" /><br />
				Email: <span id="detail_email" class="pzk-field-email" /><br />
				Phần mềm: <span id="detail_className" class="pzk-field-subjectName" /><br />
				Dịch vụ: <span id="detail_className" class="pzk-field-className" /><br />
				Thời gian báo lỗi: <span id="detail_testTime" class="pzk-field-testTime" /> ngày <span
					id="detail_testDate" class="pzk-field-testDate" /><br />
				Người tư vấn: <span id="detail_adviceName" class="pzk-field-adviceName" /><br />
				Trạng thái: <span id="detail_status" /><br />
				---------------<br />
				Ghi chú: <span id="detail_note" class="pzk-field-note" /><br />
				---------------<br />
			</div>
		</easyui.layout.panel>
	</div>
	<!-- Kết thúc form nghiệp vụ -->

	<script>
	function searchAdvice() {
		pzk.elements.dg.search({
			'fields': {
				'classId': '#searchClass',
				'studentId': '#searchStudent',
				'keyword': '#searchKeyword',
				'adviceId': '#searchAdvice',
				'status': '#searchStatus'
			}
		});
	}

	/**
	Format trạng thái lịch hẹn
	 */
	function adviceStatusFormatter(value, row, index) {
		switch (value) {
			case '-2':
				return 'Lỗi không sửa được';
			case '-1':
				return 'Lỗi, vấn đề';
			case '0':
				return 'Không có lỗi';
			case '1':
				return 'Đang sửa';
			case '2':
				return 'Đã sửa xong';
		}
	}

	/**
	Format màu sắc bản ghi
	 */
	function adviceRowStyler(index, row) {
		if (row.status == '-2') {
			return 'color: gray; font-weight: normal;';
		}
		if (row.status == '-1') {
			return 'color: red; font-weight: normal;';
		}
		if (row.status == '0') {
			return 'color: black; font-weight: normal;';
		}
		if (row.status == '1') {
			return 'color: blue; font-weight: bold;';
		}
		if (row.status == '2') {
			return 'color: green; font-weight: bold;';
		}
		return '';
	}

	function student_adviceRowStyler(index, row) {
		if (row.adviceStatus == '-2') {
			return 'color: gray; font-weight: normal;';
		}
		if (row.adviceStatus == '-1') {
			return 'color: red; font-weight: normal;';
		}
		if (row.adviceStatus == '0') {
			return 'color: black; font-weight: normal;';
		}
		if (row.adviceStatus == '1') {
			return 'color: blue; font-weight: bold;';
		}
		if (row.adviceStatus == '2') {
			return 'color: green; font-weight: bold;';
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
		return [row.studentName, row.phone, row.note].join('<br />');
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

	}
	/**
	Sắp lớp cho học sinh theo lịch hẹn
	 */
	function scheduleClassStudent() {
		/*alert('Xếp lớp');*/
		var schedule = pzk.elements.dg.getSelected();
		if (!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		if (schedule.status == '3') {
			$.messager.alert('Lỗi', 'Học sinh đã sử dụng dịch vụ');
			return false;
		}

		var classId = schedule ? schedule.classId : null;
		if (!classId) {
			$.messager.alert('Lỗi', 'Chưa chọn dịch vụ');
			return false;
		}

		var startClassDate = jQuery('#startDate').pzkVal();
		if (!startClassDate) {
			$.messager.alert('Lỗi', 'Chưa chọn ngày bắt đầu sử dụng dịch vụ');
			return false;
		}
		/** 
		 * Đánh dấu là đã sử dụng
		 * Đăng ký dịch vụ
		 */
		pzk.db.update('test_schedule', {
			id: schedule.id,
			status: 3
		}, function(resp) {
			if (!resp.errorMsg) {
				pzk.db.add('class_student', {
					studentId: schedule.studentId,
					classId: classId,
					startClassDate: startClassDate
				}, function(resp) {
					if (resp.errorMsg) {
						$.messager.show({
							title: 'Thất bại',
							msg: resp.errorMsg
						});
					} else {
						$.messager.show({
							title: 'Thành công',
							msg: 'Đã đăng ký dịch vụ thành công'
						});
						pzk.db.update('student', {
							id: schedule.studentId,
							classed: 1
						}, function(resp) {
							if (resp.errorMsg) {
								$.messager.show({
									title: 'Thất bại',
									msg: resp.errorMsg
								});
							} else {
								pzk.elements.dg.reload();
							}
						});

					}

				});

			} else {
				$.messager.show({
					title: 'Thất bại',
					msg: resp.errorMsg
				});
			}
		});
	}

	/**
	Hủy lịch hẹn
	 */
	function cancelTestSchedule() {
		var schedule = pzk.elements.dg.getSelected();
		if (!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		$.messager.confirm('Xác nhận', 'Bạn có muốn hủy tư vấn này?', function(r) {
			if (r) {
				if (schedule.status == '0') {
					pzk.db.update('test_schedule', {
						id: schedule.id,
						status: -1
					}, function(resp) {
						if (resp.errorMsg) {
							$.messager.show({
								title: 'Thất bại',
								msg: resp.errorMsg
							});
						} else {
							pzk.elements.dg.reload();
							$.messager.show({
								title: 'Thành công',
								msg: 'Bạn đã hủy báo lỗi'
							});
						}
					});

				} else {
					$.messager.alert('Thất bại', 'Chỉ học sinh chưa sử dụng dịch vụ mới được quyền hủy tư vấn');
				}
			}
		});

	}
	/**
	Thêm lịch hẹn
	 */
	function addTestSchedule() {
		var data = jQuery('#add_test_schedule').serializeForm();
		data.type = 0;
		data.status = 0;
		data.online = 1;
		pzk.db.add('student', data, function(resp) {
			var data = jQuery('#add_test_schedule').serializeForm();
			if (resp.errorMsg == false) {
				var student = resp.data;
				var id = student.id;
				data.studentId = id;
				data.type = 2;
				pzk.db.add('test_schedule', data, function(resp) {
					if (resp.errorMsg == false) {
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
		if (!schedule) {
			$.messager.alert('Lỗi', 'Chưa chọn học sinh');
			return false;
		}
		if (schedule.status == '3') {
			$.messager.alert('Lỗi',
				'Đã đăng ký dịch vụ cho học sinh này. Nếu bạn muốn xóa, hãy vào quản trị học sinh/trung tâm');
			return false;
		}
		$.messager.confirm('Xác nhận', 'Bạn có muốn xóa học sinh này?', function(r) {
			if (r) {
				pzk.db.del('student', {
					id: schedule.studentId
				}, function(resp) {
					if (resp.errorMsg) {
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

	function test_schedule_onAdd(data) {
		if (data.studentId != '0' && data.studentId != '') {
			pzk.db.update('student', {
				id: data.studentId,
				adviceStatus: data.status,
				adviceNote: data.note
			}, function(resp) {
				pzk.elements.dg_online_student.reload();
			});
		}
	}
	</script>
</div>
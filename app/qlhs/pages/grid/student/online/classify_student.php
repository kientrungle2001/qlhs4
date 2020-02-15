<!-- Nghiệp vụ xếp lớp học sinh -->
<easyui.layout.panel collapsible="true" title="Dịch vụ" width="100%">
	<span>Thêm dịch vụ: </span>
	<edu.courseSelector id="cmbClass" name="classId" defaultFilters='{"status": 1, "online": 1}' />
	<span>Ngày bắt đầu: </span>
	<input name="startStudyDate4" type="date" id="startStudyDate4" value="<?php echo date('Y-m-d', time())?>" />
	<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/add}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass', 'tableField2': 'startClassDate', 'tableFieldSource2': '#startStudyDate4'}); setTimeout(function(){$dg.reload();}, 1000);" icon="add" />
	<br />
	<span>Chuyển dịch vụ: </span>
	<form.combobox label="Chọn dịch vụ" id="cmbClass3" name="classId"
		sql="{class_online_sql}"
			layout="category-select-list"></form.combobox>
	<span> sang dịch vụ: </span>
	<edu.courseSelector id="cmbClass2" name="classId" defaultFilters='{"status": 1, "online": 1}' /><span>Ngày: </span>
			<input name="startStudyDate2" type="date" id="startStudyDate" value="<?php echo date('Y-m-d', time())?>" />
	<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/add}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass2', 'tableField2': 'startClassDate', 'tableFieldSource2': '#startStudyDate'}); $dg.addToTable({url: '{url /dtable/update}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass3', 'tableField2': 'endClassDate', 'tableFieldSource2': '#startStudyDate'}); setTimeout(function(){$dg.reload();}, 1000);" icon="add" />
	<br />
	<span>Dừng dịch vụ: </span>
	<form.combobox label="Chọn dịch vụ" id="cmbClass4" name="classId"
		sql="{class_online_sql}"
			layout="category-select-list"></form.combobox><span>Ngày: </span>
			<input name="startStudyDate3" type="date" id="startStudyDate3" value="<?php echo date('Y-m-d', time())?>" />
	<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/update}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass4', 'tableField2': 'endClassDate', 'tableFieldSource2': '#startStudyDate3'}); setTimeout(function(){$dg.reload();}, 1000);" icon="add" />
</easyui.layout.panel>
<!-- Hết nghiệp vụ xếp lớp học sinh -->
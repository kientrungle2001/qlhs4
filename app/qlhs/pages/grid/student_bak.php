<div>
	<easyui.layout.panel collapsible="true" title="Thêm học sinh" collapsed="true"> <br />
		<hform id="add-dg" method="post" title="Thêm học sinh mới">
			<strong>Tên học sinh: </strong><form.textField name="name" />
			<strong> SĐT: </strong><form.textField name="phone" /><br /><br />
			<strong> Ngày nhập học: </strong><form.textField type="date" name="startStudyDate" value="{? echo date('Y-m-d'); ?}" />
			<strong> </strong>
			<form.textField type="submit" value="Thêm học sinh" onclick="pzk.elements.dg.addMode().save('#add-dg'); return false;" />
			<strong> </strong>
			<form.textField type="reset" value="Nhập lại" />
		</hform>
	</easyui.layout.panel>
	<div style="float:left; width: 600px;">
	
	<dg.dataGrid id="dg" title="Quản lý học sinh" scriptable="true" layout="easyui/datagrid/datagrid" 
			onRowContextMenu="studentMenu" nowrap="false"
			table="student" width="600px" height="450px">
		<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
		<dg.dataGridItem field="name" width="140">Tên học sinh</dg.dataGridItem>
		<dg.dataGridItem field="phone" width="80">Số điện thoại</dg.dataGridItem>
		<!--dg.dataGridItem field="school" width="120">Trường</dg.dataGridItem-->
		<dg.dataGridItem field="currentClassNames" width="100">Lớp</dg.dataGridItem>
		<!--dg.dataGridItem field="classNames" width="100">Lớp Đã Học</dg.dataGridItem-->
		<dg.dataGridItem field="periodNames" width="100">Kỳ thanh toán</dg.dataGridItem>
		<!--dg.dataGridItem field="num_of_payment" width="40">NOP</dg.dataGridItem-->
		<!--dg.dataGridItem field="num_of_class" width="40">NOC</dg.dataGridItem-->
		<!--dg.dataGridItem field="startStudyDate" width="100">Ngày vào học</dg.dataGridItem-->
		<layout.toolbar id="dg_toolbar">
			<hform id="dg_search" onsubmit="pzk.elements.dg.search({'fields': {'name' : '#searchName', 'classNames' : '#searchClass', 'phone': '#searchPhone', 'periodId' : '#searchPeriod', 'notlikeperiodId': '#searchnotlikePeriod' }}); return false;">
				<strong>Tên học sinh: </strong><form.textField width="120px" name="name" id="searchName" />
				<strong> SĐT: </strong><form.textField width="80px" name="phone" id="searchPhone" />
				<strong> Lớp: </strong><form.combobox id="searchClass" name="classId"
			sql="select name as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox><br />
				<strong>Đã thanh toán: </strong><form.combobox id="searchPeriod" name="periodId"
			sql="select id as value, 
					name as label from `payment_period` where status=1 order by startDate DESC"
				layout="category-select-list"></form.combobox>
				<strong> Chưa thanh toán: </strong><form.combobox id="searchnotlikePeriod" name="notlikeperiodId"
			sql="select id as value, 
					name as label from `payment_period` where status=1 order by startDate DESC"
				layout="category-select-list"></form.combobox>
				<input type="submit" style="display: none;" value="Tìm" />
				<layout.toolbarItem id="searchButton" action="$dg.search({'fields': {'name' : '#searchName', 'classNames' : '#searchClass', 'phone': '#searchPhone', 'periodId' : '#searchPeriod', 'notlikeperiodId': '#searchnotlikePeriod' }})" icon="search" />
				<br />
				<layout.toolbarItem action="$dg.add()" icon="add" />
				<layout.toolbarItem action="$dg.edit()" icon="edit" />
				<layout.toolbarItem action="$dg.del()" icon="remove" />
				<layout.toolbarItem action="$dg.detail({url: '{url /student/detail}', 'gridField': 'id', 'action': 'render', 'renderRegion': '#student-detail'});" icon="sum" />
			</hform>
		</layout.toolbar>
		<wdw.dialog gridId="dg" width="700px" height="auto" title="Học sinh">
			<frm.form gridId="dg">
				<frm.formItem type="hidden" name="id" label="" />
				<frm.formItem name="name" required="true" validatebox="true" label="Tên học sinh" />
				<frm.formItem name="phone" label="Số điện thoại" />
				<frm.formItem name="school"  label="Trường" />
				<frm.formItem type="date" name="birthDate" label="Ngày sinh" />
				<frm.formItem name="address" label="Địa chỉ" />
				<frm.formItem name="parentName" label="Phụ huynh" />
				<frm.formItem type="date" name="startStudyDate" label="Ngày nhập học" value="{? echo date('Y-m-d'); ?}" />
				<frm.formItem type="date" name="endStudyDate" label="Ngày dừng học" />
			</frm.form>
		</wdw.dialog>
	</dg.dataGrid>
	</div>
	<div style="float:left; margin-left: 20px; margin-top: 20px; width: auto;">
		<easyui.layout.panel collapsible="true" title="Xếp lớp" width="100%">
		<span>Xếp lớp: </span>
		<form.combobox id="cmbClass" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox><span>Ngày vào học: </span>
		<input name="startStudyDate4" type="date" id="startStudyDate4" value="<?php echo date('Y-m-d', time())?>" />
		<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/add}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass', 'tableField2': 'startClassDate', 'tableFieldSource2': '#startStudyDate4'})" icon="add" />
		<br />
		<span>Chuyển từ lớp: </span>
		<form.combobox id="cmbClass3" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox>
		<span> sang lớp: </span>
		<form.combobox id="cmbClass2" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox><span>Ngày: </span>
				<input name="startStudyDate2" type="date" id="startStudyDate" value="<?php echo date('Y-m-d', time())?>" />
		<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/add}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass2', 'tableField2': 'startClassDate', 'tableFieldSource2': '#startStudyDate'}); $dg.addToTable({url: '{url /dtable/update}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass3', 'tableField2': 'endClassDate', 'tableFieldSource2': '#startStudyDate'})" icon="add" />
		<br />
		<span>Dừng học lớp: </span>
		<form.combobox id="cmbClass4" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox><span>Ngày: </span>
				<input name="startStudyDate3" type="date" id="startStudyDate3" value="<?php echo date('Y-m-d', time())?>" />
		<layout.toolbarItem action="$dg.addToTable({url: '{url /dtable/update}?table=class_student', 'gridField': 'studentId', 'tableField': 'classId', 'tableFieldSource': '#cmbClass4', 'tableField2': 'endClassDate', 'tableFieldSource2': '#startStudyDate3'}); $dg.reload();" icon="add" />
		</easyui.layout.panel>
		<div id="student-detail"></div>
	</div>
	<div style="clear:both;"></div>
</div>
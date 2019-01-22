<dg.dataGrid id="dg" title="Xếp lớp học sinh" scriptable="true" table="class_student" width="800px" height="450px">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="studentName" width="120">Tên học sinh</dg.dataGridItem>
	<dg.dataGridItem field="phone" width="120">Số điện thoại</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
	<dg.dataGridItem field="startDate" width="120">Ngày khai giảng</dg.dataGridItem>
	<dg.dataGridItem field="startClassDate" width="120">Ngày vào học</dg.dataGridItem>
	<dg.dataGridItem field="endClassDate" width="120">Ngày kết thúc</dg.dataGridItem>
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search" onsubmit="pzk.elements.dg.search({'fields': {'classId' : '#searchClass', 'studentName': '#searchName' }}); return false;">
			<strong>Tên học sinh: </strong><form.textField width="120px" name="name" id="searchName" />
			<strong>Lớp: </strong>
			<form.combobox id="searchClass" name="classId"
			sql="select id as value, 
					name as label from `classes` where status=1 order by name ASC"
				layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="$dg.search({'fields': {'classId' : '#searchClass', 'studentName': '#searchName' }})" icon="search" />
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail({'url': '/index.php/Demo/studentclassdetail', 'gridField': 'id'})" icon="sum" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Xếp lớp học sinh">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="classId" required="true" validatebox="true" label="Học sinh">
				<form.combobox name="studentId"
						sql="select id as value, 
								name as label from `student` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="date" name="startClassDate" required="false" label="Ngày kết thúc" />
			<frm.formItem type="date" name="endClassDate" required="false" label="Ngày kết thúc" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
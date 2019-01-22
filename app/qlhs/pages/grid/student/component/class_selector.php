<wdw.dialog id="dg_class_selector"  	
			width="700px" 			height="auto" 
			title="Chọn lớp"		layout="easyui/window/dialog">
	<dg.dataGrid id="dg_classes" 
			title="Quản lý lớp học" 
			scriptable="true" 		table="classes" 
			width="600px" 			height="400px" 
			rownumbers="false" 		pageSize="50">
		<dg.dataGridItem field="id" 			width="40">		Id				</dg.dataGridItem>
		<dg.dataGridItem field="name" 			width="120">	Tên lớp			</dg.dataGridItem>
		<dg.dataGridItem field="subjectName" 	width="120">	Môn học			</dg.dataGridItem>
		<dg.dataGridItem field="teacherName" 	width="120">	Giáo viên		</dg.dataGridItem>
		<dg.dataGridItem field="amount" 		width="100">	Học phí			</dg.dataGridItem>
		<dg.dataGridItem field="status" 		width="40">		TT				</dg.dataGridItem>
		<dg.dataGridItem field="assignName" 	width="140">	Phụ trách		</dg.dataGridItem>
		
		<layout.toolbar id="dg_classes_toolbar">
			<hform id="dg_classes_search">
				<form.combobox id="searchTeacher" name="teacherId" onChange="searchClasses()"
						sql="{teacher_sql}" layout="category-select-list"></form.combobox>
				<form.combobox id="searchSubject2" name="subjectId" onChange="searchClasses()"
						sql="{subject_sql}" layout="category-select-list"></form.combobox>
				<form.combobox id="searchLevel" name="level" onChange="searchClasses()"
						sql="{class_level_sql}" layout="category-select-list"></form.combobox>
				<form.combobox id="searchStatus" name="status" onChange="searchClasses()"
						sql="{class_status_sql}" layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="searchClasses()" icon="search" />
				<layout.toolbarItem action="$dg_classes.detail(function(row) { 
					selectClassSelector(row);
					jQuery('#dg_class_selector').dialog('close');
				});" icon="sum" />
			</hform>
		</layout.toolbar>
	</dg.dataGrid>
</wdw.dialog>

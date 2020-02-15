<dg.dataGrid id="dgteacher" title="" table="teacher_class" width="200px" height="250px" pagination="false" rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140">Tên giáo viên</dg.dataGridItem>
	<layout.toolbar id="dgteacher_toolbar">
		<hform id="dgteacher_search">
			<form.combobox 
				id="searchTeacherSubject" name="subjectId"
				sql="select id as value, 
						name as label from `subject` order by name ASC"
				layout="category-select-list"></form.combobox>
				<form.combobox 
						id="searchTeacherLevel" name="level"
						sql="select distinct(level) as value, level as label from classes order by label asc"
						layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="searchTeacher()" icon="search" />
		</hform>
		<layout.toolbarItem action="$dgteacher.detail(function(row) { jQuery('#searchTeacher').val(row.id); searchClasses();  });" icon="sum" />
		<layout.toolbarItem action="$dgteacher.detail(function(row) { jQuery('#searchTeacher').val(''); searchClasses();  });" icon="reload" />
	</layout.toolbar>
</dg.dataGrid>
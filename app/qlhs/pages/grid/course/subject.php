<dg.dataGrid id="dgsubject" title="" table="subject" width="200px" height="115px" pagination="false" rownumbers="false" defaultFilters='{"online": 1}'>
	<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140">Môn học</dg.dataGridItem>
	
	<layout.toolbar id="dgsubject_toolbar" style="display: none;">
		<layout.toolbarItem icon="sum" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').val(row.id); searchClasses(); jQuery('#searchTeacherSubject').val(row.id); searchTeacher(); });" />
		<layout.toolbarItem icon="reload" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').val(''); searchClasses(); jQuery('#searchTeacherSubject').val(''); searchTeacher(); });" />	
	</layout.toolbar>	
</dg.dataGrid>
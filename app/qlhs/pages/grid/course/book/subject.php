<dg.dataGrid id="dgsubject" title="" table="subject" width="200px" height="115px" 
		pagination="false" rownumbers="false" defaultFilters='{"online": -1}'>
	<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140">Môn học</dg.dataGridItem>
	
	<layout.toolbar id="dgsubject_toolbar" style="display: none;">
		<layout.toolbarItem icon="sum" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').pzkVal(row.id); searchClasses(); jQuery('#searchTeacherSubject').pzkVal(row.id); searchTeacher(); });" />
		<layout.toolbarItem icon="reload" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').pzkVal(''); searchClasses(); jQuery('#searchTeacherSubject').pzkVal(''); searchTeacher(); });" />	
	</layout.toolbar>	
</dg.dataGrid>
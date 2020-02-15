<dg.dataGrid id="dglevel" title="" table="level" width="200px" height="145px" pagination="false" rownumbers="false">
	<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="140">Trình độ</dg.dataGridItem>
	
	<layout.toolbar id="dglevel_toolbar" style="display: none;">
		<layout.toolbarItem action="$dglevel.detail(function(row) { jQuery('#searchLevel').val(row.id); searchClasses(); jQuery('#searchTeacherLevel').val(row.id); searchTeacher(); });" icon="sum" />
		<layout.toolbarItem action="$dglevel.detail(function(row) { jQuery('#searchLevel').val(''); searchClasses(); jQuery('#searchTeacherLevel').val(''); searchTeacher(); });" icon="reload" />
	</layout.toolbar>
</dg.dataGrid>
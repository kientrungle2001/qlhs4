<dg.dataGrid id="dg2" title="Quản lý lịch học" table="schedule" 
		width="210px" height="350px" singleSelect="false" 
		noClickRow="true"  rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
	<dg.dataGridItem field="className" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="studyDate" width="160">Ngày học</dg.dataGridItem>
	<!--dg.dataGridItem field="studyTime" width="160">Giờ học</dg.dataGridItem>
	<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem-->
	
	<layout.toolbar id="dg2_toolbar">
		<hform id="dg2_search">
			<form.combobox 
					id="searchClass2" name="classId"
					sql="select id as value, 
							name as label from `classes` where status=1 order by name ASC"
					layout="category-select-list"></form.combobox>
				<layout.toolbarItem action="$dg2.search({'fields': {'classId' : '#searchClass2' }})" icon="search" />
				<layout.toolbarItem action="$dg2.del()" icon="remove" />
		</hform>
	</layout.toolbar>
</dg.dataGrid>
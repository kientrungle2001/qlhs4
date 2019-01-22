<div>
<div style="float:left; width: 220px;">
	<dg.dataGrid id="dgsubject" title="" table="subject" width="200px" height="115px" pagination="false" rownumbers="false">
		<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
		<dg.dataGridItem field="name" width="140">Môn học</dg.dataGridItem>
		
		<layout.toolbar id="dgsubject_toolbar" style="display: none;">
			<layout.toolbarItem icon="sum" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').val(row.id); searchClasses(); jQuery('#searchTeacherSubject').val(row.id); searchTeacher(); });" />
			<layout.toolbarItem icon="reload" action="$dgsubject.detail(function(row) { jQuery('#searchSubject').val(''); searchClasses(); jQuery('#searchTeacherSubject').val(''); searchTeacher(); });" />	
		</layout.toolbar>	
	</dg.dataGrid>
	
	<dg.dataGrid id="dglevel" title="" table="level" width="200px" height="145px" pagination="false" rownumbers="false">
		<dg.dataGridItem field="id" width="20">Id</dg.dataGridItem>
		<dg.dataGridItem field="name" width="140">Trình độ</dg.dataGridItem>
		
		<layout.toolbar id="dglevel_toolbar" style="display: none;">
			<layout.toolbarItem action="$dglevel.detail(function(row) { jQuery('#searchLevel').val(row.id); searchClasses(); jQuery('#searchTeacherLevel').val(row.id); searchTeacher(); });" icon="sum" />
			<layout.toolbarItem action="$dglevel.detail(function(row) { jQuery('#searchLevel').val(''); searchClasses(); jQuery('#searchTeacherLevel').val(''); searchTeacher(); });" icon="reload" />
		</layout.toolbar>
	</dg.dataGrid>
	
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
</div>
<div style="float:left; width: 500px;">
<dg.dataGrid id="dg" title="Quản lý lớp học" scriptable="true" table="classes" width="500px" height="500px" rownumbers="false" pageSize="50">
	<dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
	<dg.dataGridItem field="name" width="120">Tên lớp</dg.dataGridItem>
	<dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
	<!--dg.dataGridItem field="level" width="120">Trình độ</dg.dataGridItem-->
	<dg.dataGridItem field="teacherName" width="120">Giáo viên</dg.dataGridItem>
	<!--dg.dataGridItem field="teacher2Name" width="120">Giáo viên 2</dg.dataGridItem-->
	<!--dg.dataGridItem field="roomName" width="100">Phòng</dg.dataGridItem-->
	<dg.dataGridItem field="startDate" width="160">Ngày bắt đầu</dg.dataGridItem>
	<dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem>
	<dg.dataGridItem field="amount" width="100">Học phí</dg.dataGridItem>
	<dg.dataGridItem field="status" width="40">TT</dg.dataGridItem>
	
	<layout.toolbar id="dg_toolbar">
		<hform id="dg_search">
			<form.combobox 
					id="searchTeacher" name="teacherId"
					sql="select id as value, 
							name as label from `teacher` order by name ASC"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchSubject" name="subjectId"
					sql="select id as value, 
							name as label from `subject` order by name ASC"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchLevel" name="level"
					sql="select distinct(level) as value, level as label from classes order by label asc"
					layout="category-select-list"></form.combobox>
			<form.combobox 
					id="searchStatus" name="status"
					sql="select distinct(status) as value, status as label from classes order by label asc"
					layout="category-select-list"></form.combobox>
			<layout.toolbarItem action="searchClasses()" icon="search" />
			<layout.toolbarItem action="$dg.add()" icon="add" />
			<layout.toolbarItem action="$dg.edit()" icon="edit" />
			<layout.toolbarItem action="$dg.del()" icon="remove" />
			<layout.toolbarItem action="$dg.detail(function(row) { 
				jQuery('#searchClass2').val(row.id); 
				$dg2.search({'fields': {'classId' : '#searchClass2' }});
				jQuery('#searchClass3').val(row.id); 
				$dg3.search({'fields': {'classId' : '#searchClass3' }});				
			});" icon="sum" />
		</hform>
	</layout.toolbar>
	<wdw.dialog gridId="dg" width="700px" height="auto" title="Lớp học">
		<frm.form gridId="dg">
			<frm.formItem type="hidden" name="id" required="false" label="" />
			<frm.formItem name="name" required="true" validatebox="true" label="Tên lớp" />
			<frm.formItem type="user-defined" name="subjectId" required="false" label="Môn học">
				<form.combobox name="subjectId"
						sql="select id as value, 
								name as label from `subject` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="level" required="true" validatebox="true" label="Trình độ" />
			<frm.formItem type="user-defined" name="teacherId" required="false" label="Giáo viên">
				<form.combobox name="teacherId"
						sql="select id as value, 
								name as label from `teacher` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="teacher2Id" required="false" label="Giáo viên 2">
				<form.combobox name="teacher2Id"
						sql="select id as value, 
								name as label from `teacher` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem type="user-defined" name="roomId" required="false" label="Phòng">
				<form.combobox name="roomId"
						sql="select id as value, 
								name as label from `room` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
			<frm.formItem name="startDate" type="date" required="false" label="Ngày bắt đầu">
			</frm.formItem>
			<frm.formItem name="endDate" type="date" required="false" label="Ngày kết thúc">
			</frm.formItem>
			<frm.formItem name="amount" required="false" label="Học phí">
			</frm.formItem>
			<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
		</frm.form>
	</wdw.dialog>
</dg.dataGrid>
</div>
<div style="float:left; margin-left: 20px; margin-top: 20px; width: auto;">
	<div layout="form/schedule">
	
	<layout.toolbarItem action="$dg.actOnSelected({
		'url': '{url /dtable/addschedule}', 
		'gridField': 'classId', 
		'fields': {
			'startDate': 'input[name=startDate]',
			'endDate' : 'input[name=endDate]',
			'weekday' : '#weekday',
			'studyTime' : '#studyTime'
		}
	}); $dg2.reload();" icon="ok" />
	</div>
	<div>
		<div style="float:left; width: 220px;">
			<dg.dataGrid id="dg2" title="Quản lý lịch học" table="schedule" 
				width="210px" height="350px" singleSelect="false" noClickRow="true"  rownumbers="false" pageSize="50">
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
		</div>
		<div style="float:left; width: 320px;">
			<dg.dataGrid id="dg3" title="Quản lý học phí" table="tuition_fee" 
				width="310px" height="350px" singleSelect="false" noClickRow="true"  rownumbers="false" pageSize="50">
				<dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
				<dg.dataGridItem field="className" width="120">Tên lớp</dg.dataGridItem>
				<dg.dataGridItem field="periodName" width="180">Kỳ thanh toán</dg.dataGridItem>
				<dg.dataGridItem field="amount" width="120">Số tiền</dg.dataGridItem>
				<!--dg.dataGridItem field="studyTime" width="160">Giờ học</dg.dataGridItem>
				<dg.dataGridItem field="status" width="100">Trạng thái</dg.dataGridItem-->
				
				<layout.toolbar id="dg3_toolbar">
					<hform id="dg3_search">
						<form.combobox 
								id="searchClass3" name="classId"
								sql="select id as value, 
										name as label from `classes` where status=1 order by name ASC"
								layout="category-select-list"></form.combobox>
							<layout.toolbarItem action="$dg3.search({'fields': {'classId' : '#searchClass3' }})" icon="search" />
							<layout.toolbarItem action="$dg3.add()" icon="add" />
							<layout.toolbarItem action="$dg3.edit()" icon="edit" />
							<layout.toolbarItem action="$dg3.del()" icon="remove" />
					</hform>
				</layout.toolbar>
				<wdw.dialog gridId="dg3" width="700px" height="auto" title="Học phí">
					<frm.form gridId="dg3">
						<frm.formItem type="hidden" name="id" required="false" label="" />
						<frm.formItem type="user-defined" name="subjectId" required="false" label="Lớp">
							<form.combobox name="classId"
									sql="select id as value, 
											name as label from `classes` where 1 order by name ASC"
										layout="category-select-list"></form.combobox>
						</frm.formItem>
						<frm.formItem type="user-defined" name="periodId" required="false" label="Kỳ thanh toán">
							<form.combobox name="periodId"
									sql="select id as value, 
											name as label from `payment_period` where 1 order by name ASC"
										layout="category-select-list"></form.combobox>
						</frm.formItem>
						<frm.formItem name="amount" required="false" label="Học phí">
						</frm.formItem>
						<frm.formItem name="status" required="true" validatebox="true" label="Trạng thái" />
					</frm.form>
				</wdw.dialog>
			</dg.dataGrid>
			
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear" />
<script type="text/javascript">
	function searchClasses() {
		pzk.elements.dg.search({
			'fields': {
				'teacherId' : '#searchTeacher', 
				'subjectId': '#searchSubject', 
				'level': '#searchLevel',
				'status': '#searchStatus'
			}
		});
	}
	function searchTeacher() {
		pzk.elements.dgteacher.search({
			'fields': {
				'subjectId': '#searchTeacherSubject', 
				'level': '#searchTeacherLevel'
			}
		});
	}
</script>
</div>
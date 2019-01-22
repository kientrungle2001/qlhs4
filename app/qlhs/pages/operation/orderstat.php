<div>
	<div style="float:left; width: 220px;">
		<strong style="color: orange;">Môn học</strong><br />
		<form.filter id="sjft" sql="select id as value, name as label from subject" onselect="jQuery('#searchSubject').val(this.value); searchClasses();" />
		<strong style="color: orange;">Trình độ</strong><br />
		<form.filter id="sjlevel" sql="select distinct(level) as value, concat('Lớp ', level) as label from classes" onselect="jQuery('#searchLevel').val(this.value); searchClasses();" />
		<strong style="color: orange;">Lớp</strong><br />
		<dg.dataGrid id="dg" title="" table="classes&filters[status]=1" width="200px" height="500px" pagination="false" pageSize="50" rownumbers="false">
			<!--dg.dataGridItem field="id" width="40">Id</dg.dataGridItem-->
			<dg.dataGridItem field="name" width="120"></dg.dataGridItem>
			
			<layout.toolbar id="dg_toolbar" style="display: none;">
				<hform id="dg_search">
					<form.combobox 
							id="searchSubject" name="subjectId"
							sql="select id as value, 
									name as label from `subject` order by name ASC"
							layout="category-select-list"></form.combobox>
					<form.combobox 
							id="searchLevel" name="level"
							sql="select distinct(level) as value, level as label from classes order by label asc"
							layout="category-select-list"></form.combobox>
					<layout.toolbarItem action="searchClasses()" icon="search" />
					<layout.toolbarItem action="$dg.detail(function(row) { 
						jQuery.ajax({url: '{url /demo/orderstatTab}?classId='+row.id, success: function(resp) {
							jQuery('#orderstatDetail').html(resp);
							jQuery.parser.parse('#orderstatDetail');
						}});  
					});" icon="sum" />
				</hform>
			</layout.toolbar>
		</dg.dataGrid>
		<script type="text/javascript">
			function searchClasses() {
				pzk.elements.dg.search({
					'fields': {
						'subjectId': '#searchSubject', 
						'level': '#searchLevel'
					}
				});
			}
		</script>
	</div>
	<div style="float:left; width: 600px;">
		<div id="orderstatDetail"></div>
		<!--edu.orderstat>
		</edu.orderstat-->
	</div>
	<div class="clear" />
</div>
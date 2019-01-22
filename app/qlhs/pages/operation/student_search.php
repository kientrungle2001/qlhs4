<div id="student_search">
	<div id="search_div">
		<frm.form id="search_form">
			<frm.formItem name="name" required="false" label="Tên học sinh" />
			<frm.formItem name="phone" required="false" label="Số điện thoại" />
			<frm.formItem type="user-defined" name="classId" required="false" validatebox="false" label="Lớp">
				<form.combobox name="classId"
						sql="select id as value, 
								name as label from `classes` where 1 order by name ASC"
							layout="category-select-list"></form.combobox>
			</frm.formItem>
		</frm.form>
	</div>
	<div id="search_result">
		<div id="student_payment_filter">
			<div layout="student_payment_filter"></div>
		</div>
		<div id="student_list">
			<!--edu.studentList layout="student_list"></edu.studentList-->
		</div>
		<div id="student_detail">
			<!--div layout="student_detail"></div-->
		</div>
		<div class="clear"></div>
		<style type="text/css">
			#student_list {
				float: left;
				width: 190px;
				
			}
			#student_list ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
			}
			#student_detail {
				float: left;
				width: 600px;
				padding-left: 5px;
				border-left: 1px solid black;
			}
			.student_active {
				background-color: #F0FFFF;
			}
		</style>
	</div>
	<script layout="student_script"></script>
</div>
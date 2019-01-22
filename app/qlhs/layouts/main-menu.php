<div style="padding:5px;border:1px solid #ddd">
<!--
	{ifpermission student/search}<a href="{url /student/search}" class="easyui-linkbutton" data-options="plain:true">Tìm kiếm</a>{/if}
-->
	{ifpermission advice/index}<a href="{url /advice}" class="easyui-linkbutton" data-options="plain:true">Tư vấn</a>{/if}
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qlhs'">Quản lý học sinh</a>
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qlkh'">Quản lý khóa học</a>
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qlmh'">Quản lý môn học/phần mềm</a>	
	{ifpermission teacher/index}
		<a href="{url /teacher}" class="easyui-linkbutton" data-options="plain:true">Giáo viên</a>
	{/if}
	{ifpermission room/index}
		<a href="{url /room}" class="easyui-linkbutton" data-options="plain:true">Phòng học</a>
	{/if}
	{ifpermission test/index}
		<a href="{url /test}" class="easyui-linkbutton" data-options="plain:true">Bài thi</a>
	{/if}
	{ifpermission demo/orderstat}<a href="{url /demo/orderstat}" class="easyui-linkbutton" data-options="plain:true">Bảng hóa đơn</a>{/if} 
	{ifpermission demo/muster}<a href="{url /demo/muster}" class="easyui-linkbutton" data-options="plain:true">Điểm danh</a>{/if}
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qltrt'">Quản lý trung tâm</a>
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qlthuchi'">Quản lý thu chi</a>
	<a href="#" class="easyui-menubutton" data-options="plain:true,menu:'#qlnguoidung'">Quản lý người dùng</a>
	{ifpermission demo/report}<a href="{url /demo/report}" class="easyui-linkbutton" data-options="plain:true">Báo cáo</a>{/if}
	
	{ifpermission demo/logout}<a href="{url /demo/logout}" class="easyui-linkbutton" data-options="plain:true">Đăng xuất</a>{/if}
</div>
<div id="qlnguoidung" style="width:100px;">
	{ifpermission profile/index}<div><a href="{url /profile}" class="easyui-linkbutton" data-options="plain:true">Người dùng</a></div>{/if}
	{ifpermission profile/type}<div><a href="{url /profile/type}" class="easyui-linkbutton" data-options="plain:true">Quyền hạn</a></div>{/if}
	{ifpermission profile/grant}<div><a href="{url /profile/grant}" class="easyui-linkbutton" data-options="plain:true">Phân quyền</a></div>{/if}
</div>
<div id="qlthuchi" style="width:100px;">
	{ifpermission student/order}<div><a href="{url /student/order}" class="easyui-linkbutton" data-options="plain:true">Hóa đơn học phí</a></div>{/if}
	{ifpermission order/createbill}<div><a href="{url /order/createbill}" class="easyui-linkbutton" data-options="plain:true">Tạo HĐC 1</a></div>{/if}
	{ifpermission order/createbill2}<div><a href="{url /order/createbill2}" class="easyui-linkbutton" data-options="plain:true">Tạo HĐC 2</a></div>{/if}
	{ifpermission order/createordermanual}<div><a href="{url /order/createordermanual}" class="easyui-linkbutton" data-options="plain:true">Tạo HĐT</a></div>{/if}
	{ifpermission order/billing}<div><a href="{url /order/billing}" class="easyui-linkbutton" data-options="plain:true">Hóa đơn chi</a></div>{/if}
	{ifpermission order/report}<div><a href="{url /order/report}" class="easyui-linkbutton" data-options="plain:true">Báo cáo Hóa đơn</a></div>{/if}
</div>
<div id="qltrt" style="width:100px;">
	{ifpermission student/index}
	<div>
		<a href="{url /student}" class="easyui-linkbutton" data-options="plain:true">Học sinh</a>
	</div>
	{/if}
	
	{ifpermission course/student}
	<div>
		<a href="{url /course/student}" class="easyui-linkbutton" data-options="plain:true">Xếp lớp</a>
	</div>
	{/if}

	{ifpermission course/index}
	<div>
		<a href="{url /course}" class="easyui-linkbutton" data-options="plain:true">Khóa học</a>
	</div>
	{/if}
	{ifpermission course/schedule}
	<div>
		<a href="{url /course/schedule}" class="easyui-linkbutton" data-options="plain:true">Lịch học</a>
	</div>
	{/if}
	{ifpermission offschedule/index}
	<div>
		<a href="{url /offschedule}" class="easyui-linkbutton" data-options="plain:true">Lịch nghỉ</a>
	</div>
	{/if}
	{ifpermission teacher/index}
	<div>
		<a href="{url /teacher}" class="easyui-linkbutton" data-options="plain:true">Giáo viên</a><br />
	</div>
	{/if}
	<!--
	<div>
		<a href="{url /demo/teaching}" class="easyui-linkbutton" data-options="plain:true">Giảng dạy</a><br />
	</div>
	-->
	{ifpermission subject/index}
	<div>
		<a href="{url /subject}" class="easyui-linkbutton" data-options="plain:true">Môn học</a><br />
	</div>
	{/if}
	{ifpermission room/index}
	<div>
		<a href="{url /room}" class="easyui-linkbutton" data-options="plain:true">Phòng học</a><br />
	</div>
	{/if}
	{ifpermission paymentperiod/index}
	<div>
		<a href="{url /paymentperiod}" class="easyui-linkbutton" data-options="plain:true">Kỳ thanh toán</a>
	</div>
	{/if}
	{ifpermission demo/paymentstat}<div><a href="{url /demo/paymentstat}" class="easyui-linkbutton" data-options="plain:true">Bảng thanh toán</a></div>{/if}
</div>
	
<div id="qlhs" style="width:100px;">
	{ifpermission student/index}
	<div>
		<a href="{url /student}" class="easyui-linkbutton" data-options="plain:true">Tất cả</a>
	</div>
	{/if}
	{ifpermission student/online}
	<div>
		<a href="{url /student/online}" class="easyui-linkbutton" data-options="plain:true">Trực tuyến</a>
	</div>
	{/if}
	{ifpermission student/center}
	<div>
		<a href="{url /student/center}" class="easyui-linkbutton" data-options="plain:true">Trung tâm</a>
	</div>
	{/if}
	{ifpermission student/unclassed}
	<div>
		<a href="{url /student/unclassed}" class="easyui-linkbutton" data-options="plain:true">Chờ xếp lớp</a>
	</div>
	{/if}
	{ifpermission student/potential}
	<div>
		<a href="{url /student/potential}" class="easyui-linkbutton" data-options="plain:true">Tiềm năng</a>
	</div>
	{/if}
	{ifpermission student/familiar}
	<div>
		<a href="{url /student/familiar}" class="easyui-linkbutton" data-options="plain:true">Thân thiết</a>
	</div>
	{/if}
</div>

<div id="qlkh">
{ifpermission course/index}
	<div>
		<a href="{url /course/index}" class="easyui-linkbutton" data-options="plain:true">Tất cả</a>
	</div>
{/if}
{ifpermission course/center}
	<div>
		<a href="{url /course/center}" class="easyui-linkbutton" data-options="plain:true">Trung tâm</a>
	</div>
{/if}
{ifpermission course/online}
	<div>
		<a href="{url /course/online}" class="easyui-linkbutton" data-options="plain:true">Trực tuyến</a>
	</div>
{/if}
</div>

<div id="qlmh">
{ifpermission subject/index}
	<div>
		<a href="{url /subject}" class="easyui-linkbutton" data-options="plain:true">Tất cả</a>
	</div>
{/if}
{ifpermission subject/center}
	<div>
		<a href="{url /subject/center}" class="easyui-linkbutton" data-options="plain:true">Môn học</a>
	</div>
{/if}
{ifpermission subject/online}
	<div>
		<a href="{url /subject/online}" class="easyui-linkbutton" data-options="plain:true">Phần mềm</a>
	</div>
{/if}
</div>

<?php
$bases = $data->getBasedPages();
?>
<form name="pageapp" id="pageapp" method="post" action="{url /ide_app_page/addPost}/{data.parentId}">
<h3>Tạo trang mới</h3>
	<input type="hidden" name="parentId" value="{data.parentId}" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="type" value="Page" />
	Loại trang : <select name="subType">
		<option value="Page">Trang thường</option>
		<option value="CommonPage">Trang tổng quát</option>
		<option value="BasedPage">Trang mẫu</option>
		<option value="DirectoryPage">Trang danh mục</option>
		<option value="DetailPage">Trang chi tiết</option>
	</select><br />
	Tên trang : 
	<input name="title" value="" /> <br />
	Dựa trên trang : 
	<select name="basePageId">
		{each $bases as $base}
			<option value="{base[id]}">{base[title]}</option>
		{/each}
	</select> <br />
	Từ khóa : 
	<input name="keywords" value="" /> <br />
	Mô tả : 
	<input name="description" value="" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
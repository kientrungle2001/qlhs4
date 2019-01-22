<form name="pageapp" id="pageapp" method="post" action="{url /ide_app_category/addPost}/{data.parentId}">
<h3>Tạo category mới</h3>
	<input type="hidden" name="parentId" value="{data.parentId}" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="type" value="Category" />
	Tên category : 
	<input name="title" value="" /> <br />
	Từ khóa : 
	<input name="keywords" value="" /> <br />
	Mô tả : 
	<input name="description" value="" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
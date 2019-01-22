<form name="pageapp" id="pageapp" method="post" action="{url /ide_app_article/addPost}/{data.parentId}">
<h3>Tạo bài viết mới</h3>
	<input type="hidden" name="parentId" value="{data.parentId}" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="type" value="Article" />
	Tên bài viết : 
	<input name="title" value="" /> <br />
	Trích đoạn :<br />
	<textarea name="brief" style="width: 100%; height: 300px;"></textarea><br />
	Nội dung :<br />
	<textarea name="content" style="width: 100%; height: 300px;"></textarea><br />
	Từ khóa : 
	<input name="keywords" value="" /> <br />
	Mô tả : 
	<input name="description" value="" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
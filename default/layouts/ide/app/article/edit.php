<?php $article = $data->getItem(); 
$parent = db_table('profile_resource')->get($article['parentId']);
?>
<?php if($parent['type'] == 'Category') { ?>
<a href="{url /ide_app_category/edit}/{article[parentId]}">Back to parent</a>
<?php } else { ?>
<a href="{url /ide_app/edit}/{article[parentId]}">Back to app</a>
<?php } ?>
<h3>{article[title]}</h3>
<form name="pageapp" id="pageapp" class="show" method="post" action="{url /ide_app_article/editPost}/{article[id]}">
	<input type="hidden" name="id" value="{article[id]}" />
	<input type="hidden" name="type" value="{article[type]}" />
	<input type="hidden" name="subType" value="{article[subType]}" />
	Tên bài viết : 
	<input name="title" value="{article[title]}" /> <br />
	Trích đoạn :<br />
	<textarea name="brief" style="width: 100%; height: 300px;">{article[brief]}</textarea><br />
	Nội dung :<br />
	<textarea name="content" style="width: 100%; height: 300px;">{article[content]}</textarea><br />
	Từ khóa : 
	<input name="keywords" value="{article[keywords]}" /> <br />
	Mô tả : 
	<input name="description" value="{article[description]}" /> <br />
	<input type="submit" value="Cập nhật" />
</form>

<?php $cat = $data->getItem(); 
$parent = db_table('profile_resource')->get($cat['parentId']);
?>
<?php if($parent['type'] == 'Category') { ?>
<a href="{url /ide_app_category/edit}/{cat[parentId]}">Back to parent</a>
<?php } else { ?>
<a href="{url /ide_app/edit}/{cat[parentId]}">Back to app</a>
<?php } ?>
<h3>{cat[title]}</h3>
<form name="pageapp" id="pageapp" class="show" method="post" action="{url /ide_app_category/editPost}/{cat[id]}">
	<input type="hidden" name="id" value="{cat[id]}" />
	<input type="hidden" name="type" value="{cat[type]}" />
	<input type="hidden" name="subType" value="{cat[subType]}" />
	Tên category : 
	<input name="title" value="{cat[title]}" /> <br />
	Từ khóa : 
	<input name="keywords" value="{cat[keywords]}" /> <br />
	Mô tả : 
	<input name="description" value="{cat[description]}" /> <br />
	<input type="submit" value="Cập nhật" />
</form>

<?php
$currentTemplate = $data->getTemplate();
?>
<form name="regionpageapp" id="regionpageapp" method="post" action="{url /ide_app_page_region/addPost}/{data.parentId}">
<h4>Tạo vùng mới</h4>
	Tên vùng : 
	<input name="title" value="" /> <br />
	Kiểu : 
	<select name="eType">
		<option value="text">Text</option>
		<option value="section">Section</option>
		<option value="image">Image</option>
		<option value="banner">Banner</option>
		<option value="gallery">Gallery</option>
		<option value="media">Media</option>
		<option value="shape">Shape</option>
		<option value="button">Button</option>
		<option value="menu">Menu</option>
		<option value="social">Social</option>
		<option value="list">List</option>
		<option value="ad">Ad</option>
		<option value="raw">Raw</option>
		<option value="object">Object</option>
	</select><br />
	Vị trí :
	<select name="region">
		<?php if(isset($currentTemplate['regions'])) { ?>
		<?php foreach($currentTemplate['regions'] as $region) { ?>
			<option value="{region[value]}">{region[label]}</option>
		<?php } ?>
		<?php } else { ?>
		<option value="menu">Menu</option>
		<option value="right">Bên phải</option>
		<?php } ?>
	</select><br />
	Thứ tự: <input name="orderNum" /><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#regionpageapp select[name=region]').val('{_REQUEST[region]}');
</script>
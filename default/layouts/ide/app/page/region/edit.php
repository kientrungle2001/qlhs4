<?php
$currentRegion = $data->getItem();
$currentPage = $data->getPage();
$currentTemplate = $data->getTemplate();
?>
<form name="regionpageapp" id="regionpageapp" method="post" action="{url /ide_app_page_region/editBuild}/{currentRegion[id]}">
<input type="hidden" name="id" value="{currentRegion[id]}" />
<h4>{currentRegion[title]}</h4>
	Tên vùng : 
	<input name="title" value="{currentRegion[title]}" /> <br />
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
	Thứ tự: <input name="orderNum" value="{currentRegion[orderNum]}" /><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#regionpageapp select[name=eType]').val('{currentRegion[eType]}');
	$('#regionpageapp select[name=region]').val('{currentRegion[region]}');
</script>
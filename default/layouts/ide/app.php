<?php 
$request = pzk_element('request');
$app = $data->getApp();
$templates = $data->getTemplates();
$pages = $data->getPages();
$currentPage = $data->getPage();
$regions = $data->getRegions();
$currentRegion = $data->getRegion();
$currentTemplate = NULL;
foreach($templates as $template) {
	if($template['id'] == $app['templateId']) {
		$currentTemplate = $template;
		break;
	}
}
?>
<style type="text/css">
.hidden {
	display: none;
}
</style>
<div>
<a href="{url /profileapps}/{app[profileId]}">Danh sách ứng dụng</a>
</div>
<h1>{app[title]}</h1>
<form name="app" id="app" class="show" method="post" action="{url /home/editapppost}">
<?php
if($currentPage) { ?>
	<input type="hidden" name="pageId" value="{currentPage[id]}" />
<?php } ?>
	<input type="hidden" name="id" value="{app[id]}" />
	Tên ứng dụng : 
	<input name="title" value="{app[title]}" /> <br />
	Domain : 
	<input name="domain" value="{app[domain]}" /> <br /> 
	Từ khóa : 
	<input name="keywords" value="{app[keywords]}" /> <br />
	Mô tả : 
	<input name="description" value="{app[description]}" /> <br />
	Giao diện : 
	<select name="templateId" value="{app[templateId]}">
		{each $templates as $template}
		<?php
			$selected = '';
			if($template['id'] == @$app['templateId']) {
				$selected = ' selected="selected"';
			}
		?>
		<option value="{template[id]}" {selected}>{template[title]}</option>
		{/each}
	</select><br />
	Layout :
	<select name="layout">
		<?php if(isset($currentTemplate['layouts'])) { ?>
		<?php foreach($currentTemplate['layouts'] as $layout) { ?>
			<option value="{layout[value]}">{layout[label]}</option>
		<?php } ?>
		<?php } else { ?>
		<option value="index">Trang chủ</option>
		<?php } ?>
	</select><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#app select[name=layout]').val('{app[layout]}');
	//$('#regionpageapp select[name=region]').val('{currentRegion[region]}');
</script>
<div>
<strong>Các trang : </strong>
{each $pages as $page}
	<a href="{url /editapp}/{app[id]}/page/{page[id]}">{page[title]}</a>
	<a href="{url /pageapp}/{app[id]}/{page[id]}" target="_blank">[#]</a>
	<a href="{url /editapp}/{app[id]}/page/{page[id]}/delete">[x]</a>
	|
{/each}
<a href="{url /editapp}/{app[id]}/page/create">Tạo trang</a>
</div>

<div>


<h3><a href="{url /editapp}/{app[id]}/page/{currentPage[id]}">{currentPage[title]}</a></h3>
<form name="pageapp" id="pageapp" class="show" method="post" action="{url /home/editpageapppost}">
	<input type="hidden" name="parentId" value="{app[id]}" />
	<input type="hidden" name="id" value="{currentPage[id]}" />
	<input type="hidden" name="type" value="{currentPage[type]}" />
	<input type="hidden" name="subType" value="{currentPage[subType]}" />
	Tên trang : 
	<input name="title" value="{currentPage[title]}" /> <br />
	Layout :
	<select name="layout">
		<?php if(isset($currentTemplate['layouts'])) { ?>
		<?php foreach($currentTemplate['layouts'] as $layout) { ?>
			<option value="{layout[value]}">{layout[label]}</option>
		<?php } ?>
		<?php } else { ?>
		<option value="index">Trang chủ</option>
		<?php } ?>
	</select><br />
	Từ khóa : 
	<input name="keywords" value="{currentPage[keywords]}" /> <br />
	Mô tả : 
	<input name="description" value="{currentPage[description]}" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#pageapp select[name=layout]').val('{currentPage[layout]}');
</script>
<?php
if($currentPage) { 
$pageLayout = pzk_parse('<ide.layout id="pageLayout" appId="'.$app['id'].'" templateId="'.$currentTemplate['id'].'" pageId="'.$currentPage['id'].'" layout="'.$currentTemplate['code'] . '/'.@$currentPage['layout'].'/abstract" />');
$pageLayout->display();
?>
<div class="hidden">
<strong>Các vùng của trang : </strong>
{each $regions as $region}
	<a href="{url /editapp}/{app[id]}/page/{currentPage[id]}/region/{region[id]}">{region[title]}</a>
	<a href="{url /editapp}/{app[id]}/page/{currentPage[id]}/region/{region[id]}/delete">[x]</a>
	|
{/each}
<a href="{url /editapp}/{app[id]}/page/{currentPage[id]}/region/create">Tạo vùng</a>
</div>
<?php if($currentRegion) { ?>
<form name="regionpageapp" id="regionpageapp" method="post" action="{url /home/editregionpageapppost}">
<h4>{currentRegion[title]}</h4>
	<input type="hidden" name="appId" value="{app[id]}" />
	<input type="hidden" name="parentId" value="{currentPage[id]}" />
	<input type="hidden" name="id" value="{currentRegion[id]}" />
	Tên vùng : 
	<input name="title" value="{currentRegion[title]}" /> <br />
	Kiểu : 
	<select name="eType">
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
	Code : <br />
	<textarea name="code" style="width: 400px; height: 300px;">{currentRegion[code]}</textarea> <br />
	Style : <br />
	<textarea name="style" style="width: 400px; height: 300px;">{currentRegion[style]}</textarea><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#regionpageapp select[name=eType]').val('{currentRegion[eType]}');
	$('#regionpageapp select[name=region]').val('{currentRegion[region]}');
</script>
<?php } else if(@$request->query['regionAction'] == 'create') { ?>
<form name="regionpageapp" id="regionpageapp" method="post" action="{url /home/editregionpageapppost}">
<h4>Tạo vùng mới</h4>
	<input type="hidden" name="appId" value="{app[id]}" />
	<input type="hidden" name="parentId" value="{currentPage[id]}" />
	Tên vùng : 
	<input name="title" value="" /> <br />
	Kiểu : 
	<select name="eType">
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
	Code : <br />
	<textarea name="code"></textarea> <br />
	Style : <br />
	<textarea name="style"></textarea><br />
	<input type="submit" value="Cập nhật" />
</form>
<script type="text/javascript">
	$('#regionpageapp select[name=region]').val('{request->query[region]}');
</script>
<?php } ?>
<iframe width="120%" height="1000px" style="-webkit-transform:scale(0.7);-moz-transform-scale(0.7);" src="{url /pageapp}/{app[id]}/{currentPage[id]}" />
<?php } else if (@$request->query['pageAction'] == 'create') { ?>
<form name="pageapp" id="pageapp" method="post" action="{url /home/editpageapppost}">
<h3>Tạo trang mới</h3>
	<input type="hidden" name="parentId" value="{app[id]}" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="type" value="Page" />
	Loại trang : <select name="subType">
		<option value="Page">Trang thường</option>
		<option value="CommonPage">Trang tổng quát</option>
	</select><br />
	Tên trang : 
	<input name="title" value="" /> <br />
	Từ khóa : 
	<input name="keywords" value="" /> <br />
	Mô tả : 
	<input name="description" value="" /> <br />
	<input type="submit" value="Cập nhật" />
</form>
<?php } ?>
</div>

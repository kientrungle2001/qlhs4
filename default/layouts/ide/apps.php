<style>
.app_item {
	margin: 10px; padding: 10px;
	border: 1px solid black;
}
</style>
<?php
$request = pzk_element('request');
$apps = $data->getApps();
$templates = $data->getTemplates();
$applications = $data->getApplications();
?>
<h1>Các ứng dụng đã đăng ký</h1>
{each $apps as $app}
<div class="app_item">
<h2>{app[title]} [#{app[id]}]</h2>
<a href="{url /upgradeapp}/{app[id]}">Nâng cấp</a> | <a href="{url /adddomainapp}/{app[id]}">Thêm domain</a> | <a href="{url /editapp}/{app[id]}">Sửa</a> | <a href="{url /profileapps}/{app[profileId]}/{app[id]}/delete">Xóa</a>
</div>
{/each}
<div>
<a href="{url /profileapps}/{app[profileId]}/create">Tạo ứng dụng mới</a>
</div>
<div>
<?php 
if(@$request->query['profileAction'] == 'create') { ?>
<form name="app" id="app" method="post" action="{url /home/editapppost}">
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="profileId" value="{data.profileId}" />
	Tên ứng dụng : 
	<input name="title" value="" /> <br />
	Domain : 
	<input name="domain" value="" /> <br /> 
	Từ khóa : 
	<input name="keywords" value="" /> <br />
	Mô tả : 
	<input name="description" value="" /> <br />
	Loại ứng dụng : 
	<select name="resourceId" value="">
		{each $applications as $application}
		<option value="{application[id]}">{application[title]}</option>
		{/each}
	</select><br />
	Giao diện : 
	<select name="templateId" value="">
		{each $templates as $template}
		<option value="{template[id]}">{template[title]}</option>
		{/each}
	</select><br />
	
	<input type="submit" value="Cập nhật" />
</form>
<?php
}
?>
</div>
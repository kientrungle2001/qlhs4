<style>
.app_item {
	margin: 10px; padding: 10px;
	border: 1px solid black;
}
</style>
<?php
$apps = $data->items;
?>
<h1>Các ứng dụng đã đăng ký</h1>
{each $apps as $app}
<div class="app_item">
	<h2>{app[title]}</h2>
	<a href="{url /ide_app/upgrade}/{app[id]}">Nâng cấp</a> | 
	<a href="{url /ide_app_domain/add}/{app[id]}">Thêm domain</a> | 
	<a href="{url /ide_app/edit}/{app[id]}">Sửa</a> | 
	<a href="{url /ide_app}/delete/{app[id]}">Xóa</a>
</div>
{/each}
<div>
	<a href="{url /ide_app}/add/{data.profileId}">Tạo ứng dụng mới</a>
</div>
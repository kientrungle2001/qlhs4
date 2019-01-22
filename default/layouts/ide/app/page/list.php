<?php 
$pages = $data->items;
$types = array();
foreach($pages as $page) {
	if(!isset($types[$page['subType']])) {
		$types[$page['subType']] = array();
	}
	$types[$page['subType']][] = $page;
}
?>
<div>
<h2>Danh sách các trang của ứng dụng</h2>
{each $types as $name=>$type}
	<h3>{name}</h3>
	{each $type as $page}
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_page}/edit/{page[id]}">{page[title]}</a>
		<a href="{url /ide_app_page}/preview/{page[id]}" target="_blank">[#]</a>
		<a href="{url /ide_app_page}/delete/{page[id]}">[x]</a>
	</div>
	{/each}
{/each}
	<h3>Action</h3>
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_page}/add/{data.appId}">Tạo trang</a>
	</div>
</div>
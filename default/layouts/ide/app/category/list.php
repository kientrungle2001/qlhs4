<?php 
$cats = $data->items;
?>
<div>
<h2>Danh sách các category</h2>
	{each $cats as $cat}
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_category}/edit/{cat[id]}">{cat[title]}</a>
		<a href="{url /ide_app_category}/delete/{cat[id]}">[x]</a>
	</div>
	{/each}
	<h3>Action</h3>
	<div style="margin: 10px; padding: 10px; border: 1px solid black;">
		<a href="{url /ide_app_category}/add/{data.parentId}">Tạo category</a>
	</div>
</div>
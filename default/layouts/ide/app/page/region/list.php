<?php 
$regions = $data->items;
?>
<div class="hidden">
<strong>Các vùng của trang : </strong>
{each $regions as $region}
	<a href="{url /ide_app_page_region}/edit/{region[id]}">{region[title]}</a>
	<a href="{url /ide_app_page_region}/delete/{region[id]}">[x]</a>
	|
{/each}
<a href="{url /ide_app_page_region}/add/{data.pageId}">Tạo vùng</a>
</div>